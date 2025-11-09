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
        Schema::create('customer_files', function (Blueprint $table) {
            $table->id();
            $table->integer("creator")->unsigned();
            $table->integer("shared_with")->unsigned()->nullable();
            $table->text("uploaded_file");
            $table->longText("comment")->nullable();
            $table->timestamps();
            $table->foreign('creator')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shared_with')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_files');
    }
};
