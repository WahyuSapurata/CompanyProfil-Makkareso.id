<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->create(
        [
            'name' => 'root',
            'model' => 'roots',
            'permission' => '',
        ]);
        Role::factory()->create(
        [
            'name' => 'admin',
            'model' => 'admins',
            'permission' => [
                "users:create", "users:read", "users:update", "users:delete",
            ],
        ]);
    }
}
