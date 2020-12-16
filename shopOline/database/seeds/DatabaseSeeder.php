<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserTypeSeeder::class);

        $this->call(ColorSeeder::class);
        $this->call(SizeSeeder::class);

        $data = [
        	[
        		'id'=>1,
        		'full_name' =>'Hoàng Hải',
        		'email'=> 'tummachine0614@gmail.com',
                'password' => bcrypt('12345678'),
                'phone' => '0123456789',
                'address' => 'Da Nang',
                'id_user_type' => '1'

            ],
            [
        		'id'=>2,
                'full_name' =>'Khách lẻ',
                'email'=> null,
                'password' => null,
                'phone' => null,
                'address' => null,
                'id_user_type' => '5'
        	],
			[
        		'id'=>3,
        		'full_name' =>'Quang Huy',
        		'email'=> 'huy@gmail.com',
                'password' => bcrypt('12345678'),
                'phone' => '0123456789',
                'address' => 'Da Nang',
                'id_user_type' => '3'

        	],
			[
        		'id'=>4,
        		'full_name' =>'Nguyên Oanh',
        		'email'=> 'oanh@gmail.com',
                'password' => bcrypt('12345678'),
                'phone' => '0123456789',
                'address' => 'Da Nang',
                'id_user_type' => '3'

        	]
        ];

        $role_users = [
        	[
        		'user_id' => 1,
        		'role_id' => 1
        	],
        	[
        		'user_id' => 3,
        		'role_id' => 2
        	],
        	[
        		'user_id' => 4,
        		'role_id' => 3
        	]
        ];
        

        DB::table('users')->insert($data);
        DB::table('role_users')->insert($role_users);
    }
}
