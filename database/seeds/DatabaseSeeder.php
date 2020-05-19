<?php

use Illuminate\Database\Seeder;

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

        /*$this->call([
            UserSeeder::class,
            BookablesTableSeeder::class
        ]);*/

        /**
         * ERROR:
         * Target class [BookablesTableSeeder] does not exist.
         *
         * Solution:
         * composer dump-autoload
         *
         * only use this CLI in development!
         * php artisan migrate:refresh --seed
         */
        $this->call(BookablesTableSeeder::class);
    }
}
