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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('fio')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('age')->nullable();
            $table->char('sex',5)->nullable();
            $table->foreignId('team_id')->default(1)->constrained('teams', 'id')->cascadeOnDelete();
            $table->foreignId('post_id')->default(1)->constrained('posts', 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
