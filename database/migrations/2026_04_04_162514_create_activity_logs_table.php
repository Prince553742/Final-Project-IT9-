<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // Add this line to create the missing task_id column!
            // We make it nullable in case some activity logs are for projects, not tasks.
            $table->foreignId('task_id')->nullable()->constrained()->onDelete('cascade'); 
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
