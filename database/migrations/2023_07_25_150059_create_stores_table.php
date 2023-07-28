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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean("active")->default(true);

            $table->string("delete_at")->nullable();
            $table->boolean("visible")->default(true);
            $table->boolean("affected")->default(false);


            $table->foreignId("owner")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("pos_id")
                ->nullable()
                ->constrained('pos', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("agent_id")
                ->nullable()
                ->constrained('agents', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId("agency_id")
                ->nullable()
                ->constrained('agencies', 'id')
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
        Schema::dropIfExists('stores');
    }
};
