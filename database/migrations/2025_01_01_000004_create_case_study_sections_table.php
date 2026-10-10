<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_study_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_study_id')->constrained()->onDelete('cascade');
            $table->string('slug');
            $table->string('title');
            $table->text('lead')->nullable();
            $table->string('eyebrow')->nullable();
            $table->string('index_label', 10)->nullable();
            $table->string('band_image')->nullable();
            $table->string('band_caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['case_study_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_study_sections');
    }
};
