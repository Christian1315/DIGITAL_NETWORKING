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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId("owner")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('number')->nullable();
            $table->string('parent')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('country_prefix')->default(229);
            $table->text('piece');
            $table->string('numero_piece')->nullable();
            $table->foreignId("type_piece")
                ->nullable()
                ->constrained('pieces', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->text('adresse')->nullable();
            $table->integer('region_state')->nullable();
            $table->string('sexe')->nullable();
            $table->string('birthday')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
