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
        Schema::create('masters', function (Blueprint $table) {
            $table->id();
            $table->text('number');
            $table->text('raison_sociale');
            $table->text('ifu');
            $table->text('ifu_file');
            $table->text('rccm');
            $table->text('rccm_file');
            $table->string('country');
            $table->text('commune');
            $table->string('phone');
            $table->string('email');
            $table->string('numero_piece');
            $table->string('description')->nullable();

            $table->integer("domaine_activite");

            $table->foreignId("type_piece")
                ->nullable()
                ->constrained('pieces', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            #L'e master est enregistré aussi comme un user, comme cela se fait pour les agents également
            #il est d'abord enregistré comme un user avant d'etre enregistrer dans la db en tant qu'un master

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

            $table->foreignId("parent")
                ->nullable()
                ->constrained('masters', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("admin")
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
        Schema::dropIfExists('masters');
    }
};
