<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(User::class, 2)->create();
        
        DB::table('users')->insert(
            [
                'name' => 'JuanMX',
                'email' => 'juanmx@mail.com',
                'password' => Hash::make('987654321'),
            ]
        );
    }
}
