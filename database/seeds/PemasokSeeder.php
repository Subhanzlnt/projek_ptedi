<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pemasoks')->insert([
            [
            'name'    => 'PT. Indofood',
            'email'   => 'Indofood@gmail.com',
            'phone'   => '087123456789',
            'address' => 'Sidoarjo',
        ],
        [
            'name'    => 'CV. Sayur Segar',
            'email'   => 'sayursegar@gmail.com',
            'phone'   => '087650354876',
            'address' => 'Malang',
        ],
        [
            'name'    => 'CV. Buah Sehat',
            'email'   => 'buahsehat@gmail.com',
            'phone'   => '081952654876',
            'address' => 'Malang',
        ],
        [
            'name'    => 'CV. Aneka Bumbu Dapur',
            'email'   => 'bumbudapur@gmail.com',
            'phone'   => '081295654876',
            'address' => 'Lamongan',
        ]
        ]);
    }
}
