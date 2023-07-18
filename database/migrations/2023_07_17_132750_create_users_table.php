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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('password')->unique();
            $table->string('api_key')->nullable();
            $table->integer('acount_status')->nullable();
            $table->string('gender')->nullable();
            $table->text('profile_picture')->nullable();

            $table->integer('parent_id')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('country');
            $table->string('complement')->nullable();
            $table->boolean('visible')->default(true);

            $table->foreignId("rang_id")
                ->nullable()
                ->constrained('rangs', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreignId("profil_id")
                ->nullable()
                ->constrained('profils', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
