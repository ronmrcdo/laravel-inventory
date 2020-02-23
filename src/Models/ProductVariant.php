<?php

namespace Ronmrcdo\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    /**
     * Table name of the model
     * 
     * @var string
     */
    protected $table = 'product_variations';

    /**
     * Disable timestamp
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fields that can be mass assigned
     * 
     * @var array
     */
    protected $fillable = [
        'product_id', 'product_sku_id', 'product_attribute_id',
        'product_attribute_value_id'
    ];

    /**
     * Protected fields during mass assigned
     * 
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Relation of the variation to the product sku
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productSku(): BelongsTo
	{
		return $this->belongsTo('Ronmrcdo\Inventory\Models\ProductSku', 'product_sku_id');
	}
    
    /**
     * Relation of the variation to the product
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(config('laravel-inventory.product'));
    }

    /**
     * Relation of the variation product to the attribute
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo('Ronmrcdo\Inventory\Models\Attribute', 'product_attribute_id');
    }

    /**
     * Relation of the variation product to the attribute option
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option(): BelongsTo
    {
        return $this->belongsTo('Ronmrcdo\Inventory\Models\AttributeValue', 'product_attribute_value_id');
    }
}
