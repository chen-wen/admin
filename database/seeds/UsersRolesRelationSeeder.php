<?php

use Illuminate\Database\Seeder;

class UsersRolesRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('system_users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);
    }
}
