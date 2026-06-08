<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        User::factory()->create([
            'name' => 'Admin Siaga Jiwa',
            'email' => 'admin@gmail.com',
        ])->assignRole($admin);

        $this->call(SimulasiKasusSeeder::class);
    }
}
