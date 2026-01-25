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
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamp('date_create');
            $table->float('sum');
            $table->foreignId('status_id')->constrained('payment_statuses', 'id')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('employees', 'id')->cascadeOnDelete();
            $table->foreignId('type_transaction_id')->constrained('type_transactions', 'id')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('companies', 'id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
};
