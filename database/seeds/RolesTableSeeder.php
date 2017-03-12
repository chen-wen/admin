<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('system_roles')->insert([
            'id' =>1,
            'name' => 'super',
            'permissions' => '{"super":1}',
        ]);

        \DB::table('system_roles')->insert([
            'id' =>2,
            'name' => 'test',
            'permissions' => '{"welcome":1}',
        ]);
    }
}
