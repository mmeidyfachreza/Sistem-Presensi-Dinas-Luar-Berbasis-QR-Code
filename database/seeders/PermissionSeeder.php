<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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

        $data = [
            ['name' => 'index employee'],
            ['name' => 'create employee'],
            ['name' => 'edit employee'],
            ['name' => 'show employee'],
            ['name' => 'delete employee'],
            ['name' => 'print employee'],
            ['name' => 'import employee'],
            ['name' => 'export employee'],
            ['name' => 'index fwa'],
            ['name' => 'create fwa'],
            ['name' => 'edit fwa'],
            ['name' => 'show fwa'],
            ['name' => 'delete fwa'],
            ['name' => 'index attendance'],
            ['name' => 'create attendance'],
            ['name' => 'show attendance'],
            ['name' => 'delete attendance'],
            ['name' => 'show qrcode'],
            ['name' => 'index report'],
            ['name' => 'setting'],
        ];

        foreach ($data as $item) {
            Permission::create($item);
        }
    }
}
