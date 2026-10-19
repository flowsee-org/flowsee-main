<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('case_studies', fn (Blueprint $table) => $table->text('lead')->nullable()->change());
    }

    public function down(): void
    {
        // Keep the wider column: narrowing it would truncate existing content.
    }
};
