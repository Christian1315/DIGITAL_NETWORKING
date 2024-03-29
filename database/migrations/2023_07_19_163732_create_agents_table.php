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

            $table->foreignId("owner")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("master_id")
                ->nullable()
                ->constrained('masters', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("admin")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("agency_id")
                ->nullable()
                ->constrained('agencies', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("pos_id")
                ->nullable()
                ->constrained('pos', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

           

            $table->string("delete_at")->nullable();
            $table->boolean("visible")->default(true);
            $table->boolean("affected")->default(false);

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
