<?php

namespace Database\Seeders;

use App\Models\SettingWebsite;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create(['name' => 'super-admin']);

        User::create([
            'name' => 'Fajri - Developer',
            'email' => 'fajri@gariskode.com',
            'password' => bcrypt('password'),
        ])->assignRole('super-admin');

        SettingWebsite::create([
            'name' => 'Torkata Tech Solution',
            'logo' => 'logo.png',
            'favicon' => 'favicon.png',
            'email' => 'hello@torkatatech.com',
            'phone' => '089613390766',
            'address' => 'Jl. Sawahan V No.1, Sawahan, Kec. Padang Tim., Kota Padang, Sumatera Barat',
            'latitude' => '-0.32177371869479526',
            'longitude' => '100.39795359131934',
            'about' => 'Torkata Tech Solution adalah perusahaan teknologi yang berfokus pada pengembangan perangkat lunak, solusi digital, dan layanan IT untuk membantu bisnis bertransformasi secara digital. Kami menyediakan layanan pembuatan website, aplikasi mobile, sistem informasi, serta konsultasi teknologi dengan tim profesional dan berpengalaman.',
        ]);
    }
}
