<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->date('start_date')->nullable();
        $table->date('due_date');
        $table->string('status')->default('Pending'); // e.g., Pending, Active, Completed
        $table->string('priority')->default('Medium'); // e.g., Low, Medium, High
        $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
