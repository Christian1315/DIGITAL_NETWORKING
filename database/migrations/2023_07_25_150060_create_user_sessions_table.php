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
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user")
                ->nullable()
                ->constrained("users", 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->string("ip")->nullable();
            $table->string("begin_date")->nullable();
            $table->string("end_date")->nullable();
            $table->string("session_time")->nullable();
            $table->boolean("active")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
