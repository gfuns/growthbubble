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
        Schema::create('task_conversations', function (Blueprint $table) {
            $table->id();
            $table->integer("task_id")->unsigned();
            $table->integer("user_id")->unsigned();
            $table->longText("comment");
            $table->text("uploaded_file")->nullable();
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('customer_tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_conversations');
    }
};
