<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MasterDataPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'city'           => ['view city', 'add city', 'edit city', 'delete city'],
            'ngo'            => ['view ngo', 'add ngo', 'edit ngo', 'delete ngo'],
            'hospital'       => ['view hospital', 'add hospital', 'edit hospital', 'delete hospital'],
            'doctor'         => ['view doctor', 'add doctor', 'edit doctor', 'delete doctor'],
            'arv staff'      => ['view arv staff', 'add arv staff', 'edit arv staff', 'delete arv staff'],
            'catching staff' => ['view catching staff', 'add catching staff', 'edit catching staff', 'delete catching staff'],
            'settings'       => ['view settings', 'edit settings'],
            'vehicle'        => ['view vehicle', 'add vehicle', 'edit vehicle', 'delete vehicle'],
            'bill master'    => ['view bill master', 'add bill master', 'edit bill master', 'delete bill master'],
            'medicine'       => ['view medicine', 'add medicine', 'edit medicine', 'delete medicine'],
            'medicare'       => ['view medicare', 'add medicare', 'edit medicare', 'delete medicare'],
        ];

        $allPermissions = [];

        foreach ($modules as $module => $permissions) {
            foreach ($permissions as $permName) {
                $permission = Permission::firstOrCreate(
                    ['name' => $permName, 'guard_name' => 'web'],
                    ['module' => $module]
                );
                $allPermissions[] = $permission;
            }
        }

        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo($allPermissions);
    }
}
