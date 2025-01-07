<?php

namespace App\Observers;

use App\Models\Inventory;
use App\Models\ProductStock;

class ProductStockObserver
{
    public function created(ProductStock $stock)
    {
        $this->createInventoryRecord(
            $stock->product_id,
            $stock->quantity,
            $stock->quantity,
            'creation',
            'Stock created'
        );
    }

    public function updated(ProductStock $stock)
    {
        if ($stock->isDirty('quantity')) {
            $oldQuantity = $stock->getOriginal('quantity');
            $newQuantity = $stock->quantity;

            $this->createInventoryRecord(
                $stock->product_id,
                $newQuantity - $oldQuantity,
                $newQuantity,
                $stock->source ?? 'manual',
                'Stock updated'
            );
//            dd($oldQuantity, $newQuantity);
        }
    }

    public function deleted(ProductStock $stock)
    {
        $this->createInventoryRecord(
            $stock->product_id,
            -$stock->quantity,
            0,
            'deletion',
            'Stock deleted'
        );
    }

    /**
     * Handle the ProductStock "restored" event.
     */
    public function restored(ProductStock $productStock): void
    {
        //
    }

    /**
     * Handle the ProductStock "force deleted" event.
     */
    public function forceDeleted(ProductStock $productStock): void
    {
        //
    }

    private function createInventoryRecord(
        int $productId,
        int $change,
        int $newStock,
        string $source,
        string $description
    ): void {
        $inventory = new Inventory();
        $inventory->product_id = $productId;
        $inventory->quantity_change = $change;
        $inventory->new_stock = $newStock;
        $inventory->source = $source;
        $inventory->description = $description;
        $inventory->save();
//        Inventory::create([
//            'product_id' => $productId,
//            'quantity_change' => $change,
//            'new_stock' => $newStock,
//            'source' => $source,
//            'description' => $description,
//        ]);
    }
}
