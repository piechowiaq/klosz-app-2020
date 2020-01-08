<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'SuperAdmin',
            'description' => 'Brtosz Piechowiak SuperAdmin',
            ]);

        $user = User::create([
            'name' => 'Bartosz',
            'surname' => 'Piechowiak',
            'email' => 'piechowiaq@gmail.com',
            'password' => bcrypt('12345678'),
            ]);

        $user->roles()->save($role);

        factory(App\User::class, 10)->create()->each(function ($user) {
            $user->roles()->save(factory(App\Role::class)->make());
            $user->companies()->save(factory(App\Company::class)->make());
        });
    }
}
