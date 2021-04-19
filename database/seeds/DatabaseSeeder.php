<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Costo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * refresca las migraciones y corre de nuevo el seeder
     * php artisan migrate:fresh --seed 
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

        factory(Costo::class, 5)->create();
    }
}
