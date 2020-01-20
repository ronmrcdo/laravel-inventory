<?php

namespace Ronmrcdo\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductSku extends Model
{
    /**
     * Table name of the model
     * 
     * @var string
     */
    protected $table = 'product_skus';

    /**
     * Disable the timestamp on model creation
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
        'product_id', 'code'
    ];

    /**
     * Fields that are guarded during mass assign
     * 
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Relation to the product
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('Ronmrcdo\Inventory\Models\Product');
    }

    /**
     * Product Variant
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variant(): HasMany
    {
        return $this->hasMany('Ronmrcdo\Inventory\Models\ProductVariant', 'product_sku_id');
    }
}