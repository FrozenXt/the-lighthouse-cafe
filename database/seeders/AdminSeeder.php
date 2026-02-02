<?php
// database/seeders/AdminSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::create([
            'name' => 'Admin',
            'email' => 'admin@lighthousecafe.com',
            'password' => Hash::make('password'), // Change this in production!
            'role' => 'admin',
            'is_active' => true
        ]);

        AdminUser::create([
            'name' => 'Manager',
            'email' => 'manager@lighthousecafe.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'is_active' => true
        ]);
    }
}
