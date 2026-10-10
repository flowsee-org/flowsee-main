<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_study_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('case_study_sections')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('step_number', 10)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_study_steps');
    }
};
