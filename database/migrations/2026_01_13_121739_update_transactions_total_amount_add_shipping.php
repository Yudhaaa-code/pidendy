<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Transaction;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $transactions = Transaction::all();
        foreach ($transactions as $transaction) {
            // Assume if product exists, we check if total matches product price
            // If product is deleted, we might skip or assume. But let's check product.
            $product = Product::find($transaction->product_id);
            if ($product) {
                // If the total amount is exactly equal to the product price, it means shipping wasn't added yet.
                // We add 20000.
                if ($transaction->total_amount == $product->price) {
                    $transaction->total_amount = $transaction->total_amount + 20000;
                    $transaction->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $transactions = Transaction::all();
        foreach ($transactions as $transaction) {
             $product = Product::find($transaction->product_id);
             if ($product) {
                 // Revert: if total is price + 20000, subtract it? 
                 // This is risky if prices changed, but for immediate rollback it might be okay.
                 if ($transaction->total_amount == ($product->price + 20000)) {
                     $transaction->total_amount = $transaction->total_amount - 20000;
                     $transaction->save();
                 }
             }
        }
    }
};
