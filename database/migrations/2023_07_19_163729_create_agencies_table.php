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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->text("number");
            $table->string("name");
            $table->string("ifu");
            $table->string("ifu_file");
            $table->string("rccm");
            $table->string("rccm_file");
            $table->string("country");
            $table->string("commune");
            $table->string("phone");
            $table->string("email");
            $table->string("numero_piece");
            $table->string("piece_file");
            $table->string("photo");
            $table->string("comment");

            $table->integer("domaine_activite");

            $table->foreignId("type_piece")
                ->constrained('pieces', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            #L'agence est enregistrée aussi comme un user, comme cela se fait pour les masters également,users et autres
            #elle est d'abord enregistrée comme un user avant d'etre enregistrer dans la db en tant qu'une agence
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

            #on lui associe son type
            $table->foreignId("type_id")
                ->constrained('agency_types', 'id')
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
        Schema::dropIfExists('agencies');
    }
};
