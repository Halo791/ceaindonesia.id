<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('admin_pages') && ! Schema::hasColumn('admin_pages', 'external_url')) {
            Schema::table('admin_pages', function (Blueprint $table) {
                $table->string('external_url')->nullable()->after('image_path');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('admin_pages') && Schema::hasColumn('admin_pages', 'external_url')) {
            Schema::table('admin_pages', function (Blueprint $table) {
                $table->dropColumn('external_url');
            });
        }
    }
};
