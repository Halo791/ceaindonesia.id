<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('admin_pages')) {
            return;
        }

        Schema::table('admin_pages', function (Blueprint $table) {
            if (! Schema::hasColumn('admin_pages', 'hero_video_path')) {
                $table->string('hero_video_path')->nullable()->after('image_path');
            }

            if (! Schema::hasColumn('admin_pages', 'header_logo_path')) {
                $table->string('header_logo_path')->nullable()->after('hero_video_path');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('admin_pages')) {
            return;
        }

        Schema::table('admin_pages', function (Blueprint $table) {
            if (Schema::hasColumn('admin_pages', 'header_logo_path')) {
                $table->dropColumn('header_logo_path');
            }

            if (Schema::hasColumn('admin_pages', 'hero_video_path')) {
                $table->dropColumn('hero_video_path');
            }
        });
    }
};
