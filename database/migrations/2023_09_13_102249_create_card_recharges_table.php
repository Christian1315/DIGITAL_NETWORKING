<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('card_recharges', function (Blueprint $table) {
            $table->id();
            $table->text("card_id");
            $table->text("card_num");
            $table->foreignId("card_type")
                ->nullable()
                ->constrained("card_types", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");
            $table->foreignId("client")
                ->nullable()
                ->constrained("clients", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->foreignId("card")
                ->nullable()
                ->constrained("cards", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->foreignId("owner")
                ->nullable()
                ->constrained("users", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->string("amount");
            $table->string("frais_amount");
            $table->string("amount_to_pay");
            $table->boolean("visible")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_recharges');
    }
};
