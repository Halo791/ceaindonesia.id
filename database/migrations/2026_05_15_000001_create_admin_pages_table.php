<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('admin_pages')) {
            Schema::create('admin_pages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('parent_id')->nullable()->constrained('admin_pages')->nullOnDelete();
                $table->string('title');
                $table->string('slug', 120)->unique();
                $table->string('menu_label')->nullable();
                $table->string('subtitle')->nullable();
                $table->longText('body')->nullable();
                $table->string('image_path')->nullable();
                $table->string('status', 30)->default('draft');
                $table->boolean('show_in_navigation')->default(false);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_pages');
    }
};
