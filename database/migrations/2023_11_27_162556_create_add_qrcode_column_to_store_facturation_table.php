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
        Schema::table('store_facturations', function (Blueprint $table) {
            $table->text("qr_code")->nullable();
            $table->boolean("normalized")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_facturations', function (Blueprint $table) {
            //
        });
    }
};
