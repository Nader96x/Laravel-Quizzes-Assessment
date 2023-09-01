<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $name = $this->ask('Enter admin name:');
        $email = $this->ask('Enter admin email:');
        $password = $this->secret('Enter admin password:');

        $admin = \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $admin->assignRole('admin');
        $this->info('Admin user created successfully.');
    }
}
