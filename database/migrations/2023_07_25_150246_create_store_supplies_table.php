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
        Schema::create('store_supplies', function (Blueprint $table) {
            $table->id();
            $table->text("comments");
            $table->foreignId("session")
                ->nullable()
                ->constrained('user_sessions', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->foreignId("owner")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("pos")
                ->nullable()
                ->constrained('pos', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("store")
                ->nullable()
                ->constrained('stores', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->boolean("status")->default(true);

            $table->text("delete_at")->nullable();
            $table->boolean("visible")->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_supplies');
    }
};
