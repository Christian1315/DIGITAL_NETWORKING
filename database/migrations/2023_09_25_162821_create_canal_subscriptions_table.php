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
        Schema::create('canal_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->text("decodeur_num");
            // // infos du client
            // $table->string('firstname');
            // $table->string('lastname');
            // $table->string('phone');
            // $table->string('country_prefix');

            $table->text("detail")->nullable();
            $table->text("receipt")->nullable();
            $table->text("payment_ref")->nullable();
            $table->text("payment_amount")->nullable();
            $table->text("payment_type")->nullable();
            $table->text("payment_status")->nullable();
            $table->text("payment_details")->nullable();
            $table->text("validation_details")->nullable();
            $table->foreignId("session")
                ->nullable()
                ->constrained('user_sessions', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->foreignId("client")
                ->nullable()
                ->constrained('clients', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->foreignId("manager")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->foreignId("agency")
                ->nullable()
                ->constrained('agencies', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->foreignId("option")
                ->nullable()
                ->constrained('canal_subscription_options', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->foreignId("formule")
                ->nullable()
                ->constrained('canal_formulas', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->string("month")->default(1);
            $table->string("amount");
            $table->foreignId("status")
                ->nullable()
                ->constrained('canal_subscription_statuses', 'id')
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");
            $table->boolean("active")->default(true);
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
        Schema::dropIfExists('canal_subscriptions');
    }
};
