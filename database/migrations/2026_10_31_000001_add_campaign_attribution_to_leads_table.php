<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table): void {
            $table->string('campaign_key', 80)->nullable()->index();
            $table->string('store_identifier', 100)->nullable();
            $table->string('utm_source', 160)->nullable();
            $table->string('utm_medium', 160)->nullable();
            $table->string('utm_campaign', 160)->nullable();
            $table->string('landing_path', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table): void {
            $table->dropIndex(['campaign_key']);
            $table->dropColumn([
                'campaign_key',
                'store_identifier',
                'utm_source',
                'utm_medium',
                'utm_campaign',
                'landing_path',
            ]);
        });
    }
};
