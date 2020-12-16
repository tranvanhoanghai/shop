<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = [
            [
        		'id_user_type'=>1,
        		'name_user_type' =>'Admin',
        		'type' =>'0'
            ],
			[
        		'id_user_type'=>2,
				'name_user_type' =>'Staff',
        		'type' =>'1'
            ],
			[
        		'id_user_type'=>3,
				'name_user_type' =>'Khách hàng',
        		'type' =>'2'
        	],
			[
        		'id_user_type'=>4,
				'name_user_type' =>'Khách hàng vip',
        		'type' =>'2'
			],
			[
        		'id_user_type'=>5,
				'name_user_type' =>'Khách lẻ',
        		'type' =>'2'
        	],
			[
        		'id_user_type'=>6,
				'name_user_type' =>'NCC',
        		'type' =>'3'
        	]
		];
        DB::table('user_types')->insert($type);
		
    }
}
