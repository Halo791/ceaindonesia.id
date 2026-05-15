<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('admin_pages')) {
            if (! Schema::hasColumn('admin_pages', 'title_en')) {
                Schema::table('admin_pages', function (Blueprint $table) {
                    $table->string('title_en')->nullable()->after('title');
                });
            }

            if (! Schema::hasColumn('admin_pages', 'menu_label_en')) {
                Schema::table('admin_pages', function (Blueprint $table) {
                    $table->string('menu_label_en')->nullable()->after('menu_label');
                });
            }

            if (! Schema::hasColumn('admin_pages', 'subtitle_en')) {
                Schema::table('admin_pages', function (Blueprint $table) {
                    $table->string('subtitle_en')->nullable()->after('subtitle');
                });
            }

            if (! Schema::hasColumn('admin_pages', 'body_en')) {
                Schema::table('admin_pages', function (Blueprint $table) {
                    $table->longText('body_en')->nullable()->after('body');
                });
            }
        }

        if (Schema::hasTable('admin_updates')) {
            if (! Schema::hasColumn('admin_updates', 'title_en')) {
                Schema::table('admin_updates', function (Blueprint $table) {
                    $table->string('title_en')->nullable()->after('title');
                });
            }

            if (! Schema::hasColumn('admin_updates', 'category_en')) {
                Schema::table('admin_updates', function (Blueprint $table) {
                    $table->string('category_en', 80)->nullable()->after('category');
                });
            }

            if (! Schema::hasColumn('admin_updates', 'excerpt_en')) {
                Schema::table('admin_updates', function (Blueprint $table) {
                    $table->string('excerpt_en')->nullable()->after('excerpt');
                });
            }

            if (! Schema::hasColumn('admin_updates', 'body_en')) {
                Schema::table('admin_updates', function (Blueprint $table) {
                    $table->longText('body_en')->nullable()->after('body');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('admin_pages')) {
            $columns = array_values(array_filter(
                ['body_en', 'subtitle_en', 'menu_label_en', 'title_en'],
                function ($column) {
                    return Schema::hasColumn('admin_pages', $column);
                }
            ));

            if (! empty($columns)) {
                Schema::table('admin_pages', function (Blueprint $table) use ($columns) {
                    $table->dropColumn($columns);
                });
            }
        }

        if (Schema::hasTable('admin_updates')) {
            $columns = array_values(array_filter(
                ['body_en', 'excerpt_en', 'category_en', 'title_en'],
                function ($column) {
                    return Schema::hasColumn('admin_updates', $column);
                }
            ));

            if (! empty($columns)) {
                Schema::table('admin_updates', function (Blueprint $table) use ($columns) {
                    $table->dropColumn($columns);
                });
            }
        }
    }
};
