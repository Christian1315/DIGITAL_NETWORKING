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
        Schema::create('store_produits', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("price");
            $table->longText("description");
            $table->foreignId("store")
                ->nullable()
                ->constrained('stores', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("category")
                ->nullable()
                ->constrained('store_categories', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("owner")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->boolean("active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_produits');
    }
};
