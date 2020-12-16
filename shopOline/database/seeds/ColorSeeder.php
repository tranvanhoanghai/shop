<?php

use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color=[
            [
                'color'=> 'BLACK'
            ],
            [
                'color'=> 'WHITE'
            ],
            [
                'color'=> 'RED'
            ],
            [
                'color'=> 'YELLOW'
            ],
            [
                'color'=> 'BLUE'
            ]
        ];
        DB::table('colors')->insert($color);

    }
}
