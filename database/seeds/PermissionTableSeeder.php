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


        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'arab_name' => 'اسم العربي',
                'eng_name' => 'english name',
                'group_name' => explode('-', $permission)[0]
            ]);
        }
    }
}
