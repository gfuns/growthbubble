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
        Schema::create('customer_tasks', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("product_id")->unsigned();
            $table->integer("user_id")->unsigned();
            $table->string('title');
            $table->string('website')->nullable();
            $table->text('task_description')->nullable();
            $table->enum('provided_access', ["yes", "no"])->default("yes");
            $table->text('attached_file')->nullable();
            $table->enum('priority', ["yes", "no"])->default("no");
            $table->enum('recurring', ["yes", "no"])->default("no");
            $table->integer('creator')->unsigned();
            $table->enum('status', ["queued", "in progress", "quality assurance", "completed", "on hold", "cancelled"])->default("queued");
            $table->date('date_assigned')->nullable();
            $table->integer('assigned_by')->unsigned()->nullable();
            $table->integer('assigned_to')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('creator')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_category')->references('id')->on('task_categories')->onDelete('cascade');
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_tasks');
    }
};
