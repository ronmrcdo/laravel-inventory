<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class AttributeValue extends Model
{
    /**
     * Table name of the attribute values
     * 
     * @var string
     */
    protected $table = 'product_attribute_values';

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
        'product_id', 'product_attribute_id', 'value'
    ];

    /**
     * Fields that can't be assigned
     * 
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Product Relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo $this
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('Ronmrcdo\Inventory\Models\Product');
    }

    /**
     * Product Relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo $this
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo('Ronmrcdo\Inventory\Models\Attribute', 'product_attribute_id');
    }
}
