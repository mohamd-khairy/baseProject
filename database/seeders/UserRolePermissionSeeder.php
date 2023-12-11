<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\RoleService;
use Illuminate\Database\Seeder;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        RoleService::handle();

        $roles = array_keys(config('roles.list'));
        $roles[] = 'admin';

        foreach ($roles as $role) {
            $user = User::create([
                'name' => handleTrans("roles.$role", lang: 'ar'),
                'email' => $role . '@wakeb.com',
                'password' => 123456,
                'email_verified_at' => now(),
            ]);

            $user->assignRole($role);
        }

    }
}
