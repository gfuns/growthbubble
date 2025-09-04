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
            $table->increments('id');
            $table->string('last_name');
            $table->string('other_names');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role_id')->unsigned();
            $table->enum("status", ["active", "suspended", "banned"])->default("active");
            $table->string('token')->nullable();
            $table->text('organization')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('auth_2fa')->nullable();
            $table->string('google2fa_secret')->nullable();
            $table->integer('profile_updated')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('user_roles')->onDelete('cascade');
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
