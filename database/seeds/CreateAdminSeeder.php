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

        // $role = Role::create([
        //     'name' => explode(' ','admin')[0],
        //     'arab_name' => 'مدير',
        //     'eng_name' => 'admin'

        // ]);


        // factory('App\Models\Team', 10)->create();

        // factory('App\User', 5)->create();

        // $permissions = Permission::pluck('id','id')->all();

        // $role->syncPermissions($permissions);

        // foreach(User::all() as $user) {

        //     $user->assignRole([$role->id]);
        // }

        //  $user = \App\Models\Team::create([

        //     'arab_name' => 'سوبر ادمن',
        //     'eng_name'  => 'super_admin',
        //     'eng_description'  => 'super_admin',
        //     'arab_description'  => 'super_admin',
        //     'role_id'  => 1,
        // ]);

        // $user = \App\User::create([

        //     'name' => 'super',
        //     'email'  => 'super_admin@delvirtto.com',
        //     'team_id'      =>1,
        //     'password'   =>  '123456789',
        // ]);

        // $user->assignRole('super_admin');

        $factory->define(User::class, function (Faker $faker) {
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),//'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'team_id' => Team::all()->random()->id,
            'flag' => $faker->randomElement([0,1]),
            //'manager' => $faker->randomElement([0,1]),
            'created_by' => 1,
            'updated_by' => 1
        ];
    });

    }
}
