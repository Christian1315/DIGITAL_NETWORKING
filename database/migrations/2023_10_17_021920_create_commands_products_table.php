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
        Schema::create('commands_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('command_id')->nullable()->constrained("store_commands", "id");
            $table->foreignId('product_id')->nullable()->constrained("store_produits", "id");
            $table->integer('qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commands_products');
    }
};
