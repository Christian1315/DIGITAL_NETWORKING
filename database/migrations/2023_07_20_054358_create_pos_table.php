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
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->string("username");
            $table->string("country");
            $table->string("phone");

            $table->foreignId("agent_id")
                ->nullable()
                ->constrained('agents', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("master_id")
                ->nullable()
                ->constrained('masters', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("owner")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("agency_id")
                ->nullable()
                ->constrained('agencies', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            #Le POS est enregistrée aussi comme un user, comme cela se fait pour les masters également,users et autres
            #elle est d'abord enregistrée comme un user avant d'etre enregistrer dans la db en tant qu'une agence
            $table->integer("user_id")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos');
    }
};
