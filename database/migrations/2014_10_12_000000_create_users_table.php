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
            $table->id();
            $table->string('name')->index()->comment('User full name');
            $table->string('email', 255)->unique()->comment('User email address');
            $table->timestamp('email_verified_at')->nullable()->comment('Timestamp when email was verified');
            $table->string('password', 60)->comment('Password hash');
            $table->rememberToken()->comment('Token for "remember me" functionality');
            $table->softDeletes()->comment('Timestamp for soft deletion');
            $table->timestamps(); // created_at and updated_at
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
