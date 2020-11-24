<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $permissions = [

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'product-list',
            'product-create',
            'product-edit',
            'product-delete',

            'admin-list',
            'admin-create',
            'admin-delete',
            'admin-edit',

            'vendor-list',
            'vendor-create',
            'vendor-delete',
            'vendor-edit',

            'order-list',
            'order-create',
            'order-delete',
            'order-edit',

            'supermarket-list',
            'supermarket-create',
            'supermarket-delete',
            'supermarket-edit',

            'branches-list',
            'branches-create',
            'branches-delete',
            'branches-edit',

            'mainCategory-list',
            'mainCategory-create',
            'mainCategory-delete',
            'mainCategory-edit',

            'subCategory-list',
            'subCategory-create',
            'subCategory-delete',
            'subCategory-edit',

            'setting-list',
            'setting-create',
            'setting-delete',
            'setting-edit',


            'reason-list',
            'reason-create',
            'reason-delete',
            'reason-edit',

            'point-list',
            'point-create',
            'point-delete',
            'point-edit'

            'team-list',
            'team-create',
            'team-delete',
            'team-edit'

            'client-list',
            'client-create',
            'client-delete',
            'client-edit'

            'location-list',
            'location-create',
            'location-delete',
            'location-edit'

            'delivery-list',
            'delivery-create',
            'delivery-delete',
            'delivery-edit'

            location delivery logs


        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'arab_name' => 'اسم العربي',
                'eng_name' => $permission,
                'group_name_ar' => $permission,
                'group_name_en' => explode('-', $permission)[0]
            ]);
        }
    }
}
