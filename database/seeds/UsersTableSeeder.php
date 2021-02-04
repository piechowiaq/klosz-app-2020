<?php

declare(strict_types=1);

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create([
            'name' => 'SuperAdmin',
            'description' => 'Bartosz Piechowiak SuperAdmin',
        ]);

        $user = User::create([
            'name' => 'Bartosz',
            'surname' => 'Piechowiak',
            'email' => 'piechowiaq@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->roles()->save($role);

        Role::create([
            'name' => 'Admin',
            'description' => 'Admin',
        ]);

        Role::create([
            'name' => 'User',
            'description' => 'User',
        ]);

        Role::create([
            'name' => 'Manager',
            'description' => 'User',
        ]);
    }
}
