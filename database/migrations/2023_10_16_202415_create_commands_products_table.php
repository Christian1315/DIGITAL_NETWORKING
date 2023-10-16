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
            $table->foreignId("product")
                ->nullable()
                ->constrained('store_produits', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->foreignId("command")
                ->nullable()
                ->constrained('store_commands', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
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
