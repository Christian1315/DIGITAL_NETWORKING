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
        Schema::table('store_produits', function (Blueprint $table) {
            $table->foreignId("product_classe")
                ->nullable()
                ->constrained('product_classes', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("product_compose")
                ->nullable()
                ->constrained('store_produits', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->string("qty")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_produits', function (Blueprint $table) {
            //
        });
    }
};
