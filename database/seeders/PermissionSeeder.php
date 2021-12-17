<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        /**
         * Create all permissions
        */

        // Permissions for school
        Permission::create([
            'name' => 'create school'
        ]);
        Permission::create([
            'name' => 'read school'
        ]);
        Permission::create([
            'name' => 'update school'
        ]);
        Permission::create([
            'name' => 'delete school'
        ]);
        Permission::create([
            'name' => 'manage school settings'
        ]);

        // Permissions for class group
        Permission::create([
            'name' => 'create class group'
        ]);
        Permission::create([
            'name' => 'read class group'
        ]);
        Permission::create([
            'name' => 'update class group'
        ]);
        Permission::create([
            'name' => 'delete class group'
        ]);

        // Permissions for class
        Permission::create([
            'name' => 'create class'
        ]);
        Permission::create([
            'name' => 'read class'
        ]);
        Permission::create([
            'name' => 'update class'
        ]);
        Permission::create([
            'name' => 'delete class'
        ]);

        // Permissions for sectionm
        Permission::create([
            'name' => 'create section'
        ]);
        Permission::create([
            'name' => 'read section'
        ]);
        Permission::create([
            'name' => 'update section'
        ]);
        Permission::create([
            'name' => 'delete section'
        ]);
        


        //header permissions (for controlling the menu headers)
        Permission::create([
            'name' => 'header-administrate'
        ]);
        Permission::create([
            'name' => 'header-schools'
        ]);
        Permission::create([
            'name' => 'menu-class'
        ]);
        Permission::create([
            'name' => 'menu-section'
        ]);


        /**
         * assign permissions to roles
        */

         //assign permissions to admin
        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo([
            'header-administrate',
            'menu-section',
            'menu-class',
            'manage school settings',
            'update school',
            'create section',
            'read section',
            'update section',
            'delete section',
            'create class',
            'read class',
            'update class',
            'delete class',
            'create class group',
            'read class group',
            'update class group',
            'delete class group',
        ]);

         //assign permissions to teacher

         //assign permissions to student

        //assign permissions to parent

        //assign permissions to librarian

        //assign permissions to accountant
    }
}
