<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $web = array('Super Admin','Admin','Karyawan','Tamu');

        foreach ($web as $value) {
            $role = Role::create(['name' => $value]);
        }

        Role::where('name','Admin')->first()->givePermissionTo([
            Permission::where('name','like','%employee%')->pluck('name'),
            Permission::where('name','like','%outgoing work%')->pluck('name'),
        ]);
    }
}
