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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->unsigned();
            $table->integer("product_id")->unsigned();
            $table->integer("plan_id")->unsigned();
            $table->string("invoice_number")->nullable();
            $table->date("due_date");
            $table->double("amount", 12, 2);
            $table->enum("status", ["active", "paid", "due", "overdue", "draft"])->default("active");
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('subscription_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
