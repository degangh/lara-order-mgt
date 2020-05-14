<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create(
            [
                'email' => 'hdg@sina.com',
                'password' => bcrypt('secret')
            ]
        );
    }
}
