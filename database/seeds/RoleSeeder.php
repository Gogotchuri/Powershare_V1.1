<?php

use Illuminate\Database\Seeder;
use App\Models\References\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //currently have 2 roles
        for($i = 1; $i < 3; $i++){
            $role = new Role();
            $role->id = $i;
            $role->name = Role::nameFromId($i);
            $role->save();
        }
    }
}
