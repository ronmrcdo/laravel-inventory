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

    public function addValue(string $value)
    {
        return $this->values()->create(['value' => $value]);
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
