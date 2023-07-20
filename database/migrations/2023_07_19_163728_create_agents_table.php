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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->text("number");
            $table->string("firstname");
            $table->string("lastname");
            $table->string("phone");
            $table->string("email");
            $table->string("sexe");

            #L'agent est enregistré aussi comme un user, comme cela se fait pour les masters également
            #il est d'abord enregistré comme un user avant d'etre enregistrer dans la db en tant qu'un agent
            $table->foreignId("user_id")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("master_id")
                ->nullable()
                ->constrained('masters', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            #on lui associe son type d'agent
            $table->foreignId("type_id")
                ->constrained('agent_types', 'id')
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
        Schema::dropIfExists('agents');
    }
};
