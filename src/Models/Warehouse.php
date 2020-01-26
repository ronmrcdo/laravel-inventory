<?php

namespace Ronmrcdo\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    /**
     * Table name in database
     * 
     * @var string
     */
    protected $table = 'warehouses';

    /**
     * Fields that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * Guarded fields
     * 
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * Warehouse has many Items
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany('Ronmrcdo\Inventory\Models\InventoryStock');
    }
}
