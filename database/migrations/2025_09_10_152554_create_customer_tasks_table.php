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
            $table->integer("project_id")->unsigned()->nullable();
            $table->string('title');
            $table->text('task_description')->nullable();
            $table->integer('task_category')->unsigned()->nullable();
            $table->enum('recurring', ["yes", "no"])->default("no");
            $table->date('recurring_date')->nullable();
            $table->enum('timeline', ["immediately", "scheduled for later"])->default("immediately");
            $table->date('date_scheduled')->nullable();
            $table->enum('provided_access', ["yes", "no"])->default("yes");
            $table->text('attached_file')->nullable();
            $table->integer('creator')->unsigned();
            $table->enum('priority', ["normal", "medium", "high"])->default("normal");
            $table->enum('status', ["queued", "in progress", "quality assurance", "completed", "on hold", "cancelled"])->default("queued");
            $table->date('date_assigned')->nullable();
            $table->integer('assigned_by')->unsigned()->nullable();
            $table->integer('assigned_to')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
