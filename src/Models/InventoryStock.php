<?php

namespace Ronmrcdo\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ronmrcdo\Inventory\Traits\HasItemStocks;

class InventoryStock extends Model
{
    use HasItemStocks;

    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'inventory_stocks';

    /**
     * Fields that can be mass assigned
     * 
     * @var array
     */
    protected $fillable = [
        'warehouse_id', 'product_sku_id', 'quantity',
        'aisle', 'row'
    ];

    /**
     * Guarded fields from mass assign
     * 
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * Local Scope to find item by sku on the inventory
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $sku
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindItemBySku(Builder $query, string $sku): Builder
    {
        return $query->whereHas('product.code', function ($q) use ($sku) {
            $q->where('code', 'LIKE', '%'. $sku .'%');
        });
    }

    /**
     * Local scope to find an item based on product name
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $sku
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindItem(Builder $query, string $product): Builder
    {
        return $query->whereHas('product.product', function ($q) use ($product) {
            return $q->where('name', 'LIKE', '%'. $product .'%');
        });
    }

    /**
     * Relation to the warehouse
     * 
     * @return \lluminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo('Ronmrcdo\Inventory\Models\Warehouse');
    }

    /**
     * Relation to the product
     * 
     * @return \lluminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('Ronmrcdo\Inventory\Models\ProductSku' ,'product_sku_id');
    }

    /**
     * Relation to the stock Movements
     * 
     * @return \lluminate\Database\Eloquent\Relations\HasMany
     */
    public function movements(): HasMany
    {
        return $this->hasMany('Ronmrcdo\Inventory\Models\InventoryStockMovement', 'stock_id', 'id');
    }
}
