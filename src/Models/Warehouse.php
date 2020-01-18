<?php

namespace Ronmrcdo\Inventory\Models;

use Illuminate\Database\Eloquent\Model;

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
}
