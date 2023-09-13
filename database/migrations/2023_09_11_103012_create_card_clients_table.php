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
        Schema::create('card_clients', function (Blueprint $table) {
            $table->id();
            $table->text("firstname");
            $table->text("lastname");
            $table->text("birthday");
            $table->text("country");
            $table->text("gender");
            $table->text("resid_adress");
            $table->text("city");
            $table->text("departement");
            $table->text("phone");
            $table->text("email");
            $table->foreignId("piece")
                ->nullable()
                ->constrained("pieces", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->text("piece_picture");
            $table->text("souscrib_form_picture");
            $table->foreignId("card_type")
                ->nullable()
                ->constrained("card_types", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->foreignId("owner")
                ->nullable()
                ->constrained("users", "id")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");
            $table->boolean("visible")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_clients');
    }
};
