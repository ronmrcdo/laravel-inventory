<?php

namespace Ronmrcdo\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    /**
     * Table name of the model
     * 
     * @var string
     */
    protected $table = 'product_attributes';

    /**
     * Disable the timestamp on model creation
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fields that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'product_id', 'name'
    ];

    /**
     * Fields that can't be assign
     * 
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Add Value on the attribute
     * 
     * @param string|array $value
     */
    public function addValue($value)
    {
        if (is_array($value)) {
            $terms = collect($value)->map(function ($term) {
                return ['value' => $term];
            })
            ->values()
            ->toArray();

            return $this->values()->createMany($terms);
        }
        return $this->values()->create(['value' => $value]);
    }

    /**
     * Remove a term on an attribute
     * 
     * @param string $term
     */
    public function removeValue($term)
    {
        return $this->values()->where('value', $term)->firstOrFail()->delete();
    }

    /**
     * Relation of the attribute to the product
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo $this
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('Ronmrcdo\Inventory\Models\Product');
    }

    /**
     * Relation to the values
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany $this
     */
    public function values(): HasMany
    {
        return $this->hasMany('Ronmrcdo\Inventory\Models\AttributeValue', 'product_attribute_id');
    }
}
