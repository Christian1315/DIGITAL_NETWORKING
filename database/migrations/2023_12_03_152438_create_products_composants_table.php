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
        Schema::create('products_composants', function (Blueprint $table) {
            $table->id();
            $table->foreignId("compose")
                ->nullable()
                ->constrained("store_produits", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->foreignId("composant")
                ->nullable()
                ->constrained("store_produits", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");
            $table->string("qty");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_composants');
    }
};
