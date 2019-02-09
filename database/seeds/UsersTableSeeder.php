<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Models\User::class, 2)->create();
        $datas = [
            [
                'name' => 'Admin - admin',
                'email' => 'admin@mail.com',
                'password' => app('hash')->make('admin123'),
            ],
            [
                'name' => 'User - user',
                'email' => 'user@mail.com',
                'password' => app('hash')->make('user123'),
            ]
        ];

        foreach ($datas as $data) {
            User::create($data);
        }
    }
}
