<?php

use App\Models\Permission;
use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        factory('App\User', 5)->create();

        $role = Role::create([
            'name' => explode(' ','admin')[0],
            'arab_name' => 'مدير',
            'eng_name' => 'admin'

        ]);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        foreach(User::all() as $user) {

            $user->assignRole([$role->id]);
        }
    }
}
