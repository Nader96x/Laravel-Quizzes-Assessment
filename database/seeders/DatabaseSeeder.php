<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Quiz;
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

        Role::findOrCreate('admin');
        Role::findOrCreate('user');

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password'=>bcrypt('123456'),
        ])->assignRole('admin');

        User::factory()->create([
            'name' => 'Student',
            'email' => 'user@user.com',
            'password'=>bcrypt('123456'),
        ])->assignRole('user');

        Quiz::factory()->count(4)->create();

        $this->call([
            QuestionSeeder::class,
        ]);


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
