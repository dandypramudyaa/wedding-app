<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage users',
            'manage roles',
            'manage events',
            'manage gallery',
            'manage rsvps',
            'manage gifts',
            'manage story',
            'view dashboard',
            'submit rsvp',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $editor->syncPermissions([
            'view dashboard',
            'manage events',
            'manage gallery',
            'manage story',
            'manage rsvps',
            'manage gifts',
        ]);

        $guest = Role::firstOrCreate(['name' => 'guest', 'guard_name' => 'web']);
        $guest->syncPermissions(['submit rsvp']);

        $adminUser = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Wedding Admin',
                'email' => 'admin@wedding.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->syncRoles(['admin']);

        $editorUser = User::firstOrCreate(
            ['username' => 'editor'],
            [
                'name' => 'Wedding Editor',
                'email' => 'editor@wedding.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $editorUser->syncRoles(['editor']);

        $guestUser = User::firstOrCreate(
            ['username' => 'guest'],
            [
                'name' => 'Guest User',
                'email' => 'guest@wedding.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $guestUser->syncRoles(['guest']);
    }
}
