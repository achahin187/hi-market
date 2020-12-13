<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

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
//       $deleted = Role::whereNotNull("id")->delete();
//
//        Permission::whereNotNull("id")->delete();
        $permissions = [

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'product-clone',
            'product-export',
            'product-import',
            'product-download',
            'product-active',


            'admin-list',
            'admin-create',
            'admin-delete',
            'admin-edit',
            'admin-active',


            'vendor-list',
            'vendor-create',
            'vendor-delete',
            'vendor-edit',
            'vendor-active',


            'order-list',
            'order-create',
            'order-delete',
            'order-edit',
            'order-cancel',
            'order-rollback',
            'order-assign',
            'order-previous',
            'order-next',
            'order-assign',
            

            'order-show-canceled-orders ',
            'order-edit-client-orderStatus',
            'order-edit-client-order-main-details',
            'order-edit-client-info',
            'order-edit-client-product',
            'order-edit-by-client-orderCancel',

            'supermarket-list',
            'supermarket-create',
            'supermarket-delete',
            'supermarket-edit',
            'supermarket-active',

            'supermarketAdmin-list',
            'supermarketAdmin-create',
            'supermarketAdmin-delete',
            'supermarketAdmin-edit',
            'supermarketAdmin-active', //do

            'branches-list',
            'branches-create',
            'branches-delete',
            'branches-edit',
            'branches-active',

            'category-list',
            'category-create',
            'category-delete',
            'category-edit',
            // 'category-active',


            'setting-list',

            'reason-list',
            'reason-create',
            'reason-edit',
            'reason-active',
            //"reason-delete",

            'point-list',
            'point-create',
            'point-delete',
            'point-edit',
            'point-active',

            'team-list',
            'team-create',
            'team-delete',
            'team-edit',
            'team-active',

            'client-list',
            'client-create',
            'client-delete',
            'client-edit',
            'client-active',

            'location-list',
            'location-create',
            'location-delete',
            'location-edit',
            'location-active',

            'delivery-list',
            'delivery-create',
            'delivery-delete',
            'delivery-edit',
            'delivery-active',

            'logs-list',
            'logs-create',
            'logs-delete',
            'logs-edit',

            'offer-list',
            'offer-create',
            'offer-delete',
            'offer-edit',
            'offer-active',

        ];

        $roles = [
            'super_admin',
            'supermarket_admin',
            'delivery_admin',
            'driver',
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

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
                'guard_name' => 'web',
                'arab_name' => $role,
                'eng_name' => $role,
            ]);
        }


        $team = \App\Models\Team::create([

            'arab_name' => 'سوبر ادمن',
            'eng_name' => 'super_admin',
            'eng_description' => 'super_admin',
            'arab_description' => 'super_admin',
            'role_id' => 1,
        ]);


        $user = \App\User::create([

            'name' => 'super',
            'email' => 'super_admin@delivertto.com',
            'team_id' => 1,
            'password' => '123456789',
        ]);

        $role = \App\Models\Role::where('name', 'super_admin')->first();
        $all_permissions = \App\Models\Permission::all();

        $assignRole = $user->assignRole($role);

        // foreach ($all_permissions as  $value) {

        $role->givePermissionTo($all_permissions);
        //

        // $Permissions = $role->permissions;

        // $user->givePermissionTo($all_permissions);
    }
}
