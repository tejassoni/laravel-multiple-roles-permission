<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            'role-list', 
            'role-create', 
            'role-edit', 
            'role-delete', 
            'product-list', 
            'product-create', 
            'product-edit', 
            'product-delete',
            'order-list', 
            'order-create', 
            'order-edit', 
            'order-delete'  
         ]; 
         foreach ($permissions as $permission) { 
              Permission::create(['name' => $permission]); 
         }
    }
}
