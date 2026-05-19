<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('admin_pages') && ! Schema::hasColumn('admin_pages', 'navigation_parent_key')) {
            Schema::table('admin_pages', function (Blueprint $table) {
                $table->string('navigation_parent_key', 190)->nullable()->after('parent_id')->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('admin_pages') && Schema::hasColumn('admin_pages', 'navigation_parent_key')) {
            Schema::table('admin_pages', function (Blueprint $table) {
                $table->dropIndex(['navigation_parent_key']);
                $table->dropColumn('navigation_parent_key');
            });
        }
    }
};
