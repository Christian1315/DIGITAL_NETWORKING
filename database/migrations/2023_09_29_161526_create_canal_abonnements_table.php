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
        Schema::create('canal_abonnements', function (Blueprint $table) {
            $table->id();
            $table->foreignId("session")
                ->nullable()
                ->constrained('user_sessions', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->text("number");
            $table->foreignId("manager")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreignId("client")
                ->nullable()
                ->constrained('clients', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->boolean("visible")->default(true);
            $table->boolean("deleted_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canal_abonnements');
    }
};
