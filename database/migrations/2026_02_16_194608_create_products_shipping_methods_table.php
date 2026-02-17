<?php

use App\Models\Product;
use App\Models\ShippingMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products_shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(shippingMethod::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(product::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_shipping_methods');
    }
};
