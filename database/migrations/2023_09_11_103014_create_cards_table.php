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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->integer("card_id");
            $table->text("card_num");
            $table->text("expire_date");
            $table->longText("comment")->nullable();

            $table->foreignId("type")
                ->nullable()
                ->constrained("card_types", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->foreignId("client")
                ->nullable()
                ->constrained("card_clients", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->foreignId("owner")
                ->nullable()
                ->constrained("users", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->foreignId("agency")
                ->nullable()
                ->constrained("agencies", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");
            $table->foreignId("status")
                ->default(1)
                ->constrained("card_statuses", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");
            $table->boolean("visible")->default(true);
            $table->boolean("affected")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
