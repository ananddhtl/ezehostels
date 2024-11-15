<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name'      => 'Easy Hostel',
            'email'     => 'easyhostel@gmail.com',
            'password'  => bcrypt('easyhostel@gmail.com@%#65'),
            'type'      =>  'super-admin',
        ]);
    }
}
