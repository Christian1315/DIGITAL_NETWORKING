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
        Schema::create('rights', function (Blueprint $table) {
            $table->id();
            $table->text("label");

            $table->foreignId("profil_id")
                ->constrained('profils', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreignId("rang_id")
                ->constrained('rangs', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreignId("action_id")
                ->constrained('actions', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rights');
    }
};
