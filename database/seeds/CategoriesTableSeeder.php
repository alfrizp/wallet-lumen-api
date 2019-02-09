<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name' => 'Makanan',
                'user_id' => 1
            ],
            [
                'name' => 'Minuman',
                'user_id' => 2
            ],
            [
                'name' => 'Perjalanan',
                'user_id' => 1
            ],
            [
                'name' => 'Bensin',
                'user_id' => 2
            ],
            [
                'name' => 'Liburan',
                'user_id' => 1
            ],
        ];

        foreach ($datas as $data) {
            Category::create($data);
        }
    }
}
