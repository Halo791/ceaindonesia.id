<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('admin_contents')) {
            DB::statement("ALTER TABLE admin_contents MODIFY item_key varchar(150) NOT NULL DEFAULT ''");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('admin_contents')) {
            DB::statement("ALTER TABLE admin_contents MODIFY item_key varchar(100) NOT NULL DEFAULT ''");
        }
    }
};
