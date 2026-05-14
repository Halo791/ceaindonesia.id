<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('admin_users')) {
            Schema::create('admin_users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('username', 100)->unique();
                $table->string('password_hash');
                $table->string('role', 30)->default('member');
                $table->string('section_key', 100)->nullable();
                $table->string('item_key', 150)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        $now = now();
        $defaultAdminPassword = (string) env('ADMIN_PASSWORD', 'Admin@2026');
        $defaultMemberPassword = (string) env('SIMPUL_DEFAULT_PASSWORD', 'Simpul@2026');
        $defaultMemberPassword = $defaultMemberPassword !== '' ? $defaultMemberPassword : 'Simpul@2026';

        $rows = [[
            'name' => 'Super Admin',
            'username' => (string) env('ADMIN_USERNAME', 'admin'),
            'password_hash' => Hash::make($defaultAdminPassword !== '' ? $defaultAdminPassword : 'Admin@2026'),
            'role' => 'super_admin',
            'section_key' => null,
            'item_key' => null,
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]];

        foreach (config('cea.admin_member_accounts', []) as $account) {
            $rows[] = [
                'name' => $account['name'],
                'username' => $account['username'],
                'password_hash' => Hash::make($defaultMemberPassword),
                'role' => 'member',
                'section_key' => $account['section_key'],
                'item_key' => $account['item_key'],
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach ($rows as $row) {
            $existing = DB::table('admin_users')->where('username', $row['username'])->exists();

            if ($existing) {
                $update = $row;
                unset($update['username'], $update['password_hash'], $update['created_at']);
                DB::table('admin_users')->where('username', $row['username'])->update($update);

                continue;
            }

            DB::table('admin_users')->insert($row);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};
