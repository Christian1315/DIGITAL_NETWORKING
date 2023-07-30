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
        Schema::create('store_tables', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("capacity");
            $table->boolean("status")->default(true);

            $table->foreignId("store")
                ->nullable()
                ->constrained('stores', 'id')
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
        Schema::dropIfExists('store_tables');
    }
};
