<?php

use Illuminate\Database\Seeder;

use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'id'=>1,
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => json_encode([
                'login-dashboard'=> true,
                'sale'=> true,
                'view-user'=> true,
                'act-user'=> true,
                'view-product'=> true,
                'act-product'=> true,
                'view-category'=> true,
                'act-category'=> true,
                'view-customer'=> true,
                'act-customer'=> true,
                'view-suppliers'=> true,
                'act-suppliers'=> true,
                'view-bill-order'=> true,
                'act-bill-order'=> true,
                'view-bill-import'=> true,
                'act-bill-import'=> true,
                'act-prices'=> true,    // Thiết lập giá
                'view-slide'=> true,
                'act-slide'=> true,
                'view-blog'=> true,
                'act-blog'=> true,
                'view-contact'=> true,
                'act-contact'=> true,
                // 'act-shipping'=> true,
                // 'act-local'=> true,
                // 'view-product'=> true
            ])
        ]);

        $staff = Role::create([
            'id'=>2,
            'name' => 'Staff',
            'slug' => 'staff',
            'permissions' => json_encode([
                'login-dashboard'=> true,
                'view-product'=> true
            ])
        ]);

        $guest = Role::create([
            'id'=>3,
            'name' => 'Guest',
            'slug' => 'guest',
            'permissions' => json_encode([
                'view-product'=> true
            ])
        ]);

    }
}
