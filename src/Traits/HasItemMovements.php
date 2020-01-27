<?php

namespace Ronmrcdo\Inventory\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasItemMovements
{
	/**
     * Rolls back the current movement.
     *
     * @param bool $recursive
     *
     * @return mixed
     */
    public function rollback($recursive = false)
    {
        $stock = $this->stock;

        return $stock->rollback($this, $recursive);
	}

	/**
     * Stock relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock(): BelongsTo
    {
        return $this->belongsTo('Ronmrcdo\Inventory\Models\InventoryStock', 'stock_id', 'id');
    }
}