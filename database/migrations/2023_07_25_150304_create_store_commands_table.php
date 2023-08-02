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
        Schema::create('store_commands', function (Blueprint $table) {
            $table->id();
            $table->foreignId("session")
                ->nullable()
                ->constrained('user_sessions', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->string("qty");
            $table->string("rate")->nullable();
            $table->string("amount");

            $table->foreignId("store")
                ->nullable()
                ->constrained('stores', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("table")
                ->nullable()
                ->constrained('store_tables', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("product")
                ->nullable()
                ->constrained('store_produits', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("owner")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->string("delete_at")->nullable();
            $table->boolean("visible")->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_commands');
    }
};
