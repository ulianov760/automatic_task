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
        Schema::create('tasks', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description');
                $table->timestamp('date_create')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('date_finish');
                $table->foreignId('priority_id')->constrained('priorities', 'id')->cascadeOnDelete();
                $table->foreignId('executor_id')->constrained('employees', 'id')->cascadeOnDelete();
                $table->foreignId('author_id')->constrained('employees', 'id')->cascadeOnDelete();
                $table->foreignId('group_id')->constrained('groups', 'id')->cascadeOnDelete();
                $table->foreignId('status_id')->constrained('statuses', 'id')->cascadeOnDelete();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
