<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section_key', 100);
            $table->string('item_key', 150)->default('');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('body')->nullable();
            $table->string('image_path')->nullable();
            $table->string('source_href')->nullable();
            $table->string('status', 30)->default('draft');
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['section_key', 'item_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_contents');
    }
};
