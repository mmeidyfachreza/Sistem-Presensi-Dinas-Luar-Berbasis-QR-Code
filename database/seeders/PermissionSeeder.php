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
            ['name' => 'employee index'],
            ['name' => 'employee create'],
            ['name' => 'employee edit'],
            ['name' => 'employee show'],
            ['name' => 'employee delete'],
            ['name' => 'employee print'],
            ['name' => 'employee import'],
            ['name' => 'employee export'],
            ['name' => 'outoging work index'],
            ['name' => 'outoging work create'],
            ['name' => 'outoging work edit'],
            ['name' => 'outoging work show'],
            ['name' => 'outoging work delete'],
            ['name' => 'log index'],
        ];

        foreach ($data as $item) {
            Permission::create($item);
        }
    }
}
