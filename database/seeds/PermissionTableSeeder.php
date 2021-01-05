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


            'admin-list',
            'admin-create',
            'admin-delete',
            'admin-edit',
            'admin-active',

            'supermarketAdmin-list',
            'supermarketAdmin-create',
            'supermarketAdmin-delete',
            'supermarketAdmin-edit',
            'supermarketAdmin-active', //do

            'deliveryAdmin-list',
            'deliveryAdmin-create',
            'deliveryAdmin-delete',
            'deliveryAdmin-edit',
            'deliveryAdmin-active', //do


            'driver-list',
            'driver-create',
            'driver-delete',
            'driver-edit',
            'driver-active',


            'order-list',
            'order-create',
            'order-delete',
            'order-edit',
            'order-edit-client-info',
            'order-edit-client-order-main-details',
            'order-edit-client-product',
            'order-cancel',
            'order-rollback',
            'order-assign',
            'order-previous',
            'order-next',
            'order-show-canceled-orders',
          
            
            'supermarket-list',
            'supermarket-create',
            'supermarket-delete',
            'supermarket-edit',
            'supermarket-active',


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

            'vendor-list',
            'vendor-create',
            'vendor-delete',
            'vendor-edit',
            'vendor-active',

            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'product-clone',
            'product-export',
            'product-import',
            'product-download',
            'product-active',


            'offer-list',
            'offer-create',
            'offer-delete',
            'offer-edit',
            'offer-active',


            'point-list',
            'point-create',
            'point-delete',
            'point-edit',
            'point-active', 


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


            'financial-list-branch',
            'financial-delivery-list',
            'financial-delivery-details',
 
            'reason-list',
            'reason-create',
            'reason-edit',
            'reason-active',
            //"reason-delete",           

            'help-list',
            'help-create',
            'help-delete',
            'help-edit',

            'contactUs-list',
            'contactUs-seen',
            'contactUs-delete',
            'contactUs-edit',


            'logs-list',
            'logs-create',
            'logs-delete',
            'logs-edit',


            'setting-list',
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
