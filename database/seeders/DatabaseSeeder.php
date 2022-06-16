<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            EmployeeSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class
        ]);
        Setting::create(['tolerance_distance'=>10]);
        $user = User::create([
            'username' => 'admin',
            'password' => '$2y$10$sntWCL1bS5jqPFmVVZ.j2uZIXdrMs1TBPzr99XV3Rrk5aixpdbF5.', //enpass skripsi
        ]);
        $user->assignRole('Super Admin');

        \App\Models\User::factory(20)->create();
        \App\Models\FieldWorkActivity::factory(10)->create();
    }
}
