<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('admin_updates')) {
            Schema::create('admin_updates', function (Blueprint $table) {
                $table->id();
                $table->string('owner_section_key', 100);
                $table->string('owner_item_key', 150)->default('');
                $table->string('title');
                $table->string('title_en')->nullable();
                $table->string('slug', 150)->unique();
                $table->string('category', 80)->default('Berita');
                $table->string('category_en', 80)->nullable();
                $table->string('excerpt')->nullable();
                $table->string('excerpt_en')->nullable();
                $table->longText('body')->nullable();
                $table->longText('body_en')->nullable();
                $table->string('image_path')->nullable();
                $table->string('status', 30)->default('draft');
                $table->timestamp('published_at')->nullable();
                $table->timestamps();

                $table->index(['owner_section_key', 'owner_item_key']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_updates');
    }
};
