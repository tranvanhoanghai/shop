<?php

use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size=[
            [
                'size'=> 'FREE SIZE'
            ],
            [
                'size'=> 'S'
            ],
            [
                'size'=> 'M'
            ],
            [
                'size'=> 'L'
            ],
            [
                'size'=> 'XL'
            ],
            [
                'size'=> 'XXL'
            ]
        ];
        DB::table('sizes')->insert($size);

    }
}
