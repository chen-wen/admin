<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('system_users')->insert([
            'name' => 'Demo',
            'email' => 'demo@demo.com',
            'password' => password_hash('secret', PASSWORD_DEFAULT),
        ]);
    }
}
