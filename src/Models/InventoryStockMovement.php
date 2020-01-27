<?php

namespace Ronmrcdo\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ronmrcdo\Inventory\Traits\HasItemMovements;

class InventoryStockMovement extends Model
{
    use HasItemMovements;

    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'inventory_stock_movements';

    /**
     * Fields that can be mass assigned
     * 
     * @var arary
     */
    protected $fillable = [
        'stock_id', 'before', 'after', 'cost',
        'reason'
    ];

    /**
     * Guarded fields that can't be mass assign
     * 
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
