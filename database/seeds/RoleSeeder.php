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
 
        for ($id = 1; $id <= Role::numCategories(); $id++) { 
            $role = new Role();
            $role->id = $id;
            $role->name = Role::nameFromId($id);
            $role->save();
        }
    }
}
