<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        $permissions = [
            ['name'=>'Register_users'],
            ['name'=>'Assign_roles'],
            ['name'=>'Delete_journal'],
            ['name'=>'Add_journal'],
            ['name'=>'Assign_journal'],  
        ];
        $roles = [
            ['name'=>'MOE'],
            ['name'=>'JHI'],
            ['name'=>'EVAL_HEAD'],
            ['name'=>'EVAL'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        foreach ($roles as $role) {
            Role::create($role);
        }

        Role::findByName('MOE')->givePermissionTo([
            'Assign_journal',
            'Add_journal',
            'Delete_journal',
            'Assign_roles',
            'Register_users'
        ]);
        // Role::findByName('JHI')->givePermissionTo([
        //     'Assign_journal'
        // ]);
        // Role::findByName('EVAL_HEAD');
        // Role::findByName('EVAL');

    }
}
