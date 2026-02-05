<?php

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
     Schema::create('variants', function (Blueprint $table) {
    $table->id();

    $table->foreignId('product_id')
          ->constrained()
          ->cascadeOnUpdate()
          ->restrictOnDelete();

    $table->string('size', 10);
    $table->string('color', 30);

    $table->string('sku')->unique();

    $table->integer('current_stock')->default(0);

    $table->timestamps();

    $table->unique(['product_id', 'size', 'color']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
