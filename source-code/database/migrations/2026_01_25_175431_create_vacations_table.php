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
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamp('date_start');
            $table->timestamp('date_finish');
            $table->foreignId('status_id')->default(1)->constrained('vacation_statuses', 'id')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('employees', 'id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacations');
    }
};
