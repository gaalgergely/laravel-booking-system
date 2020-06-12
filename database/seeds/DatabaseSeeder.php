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
        /**
         * ERROR:
         * Target class [BookablesTableSeeder] does not exist.
         *
         * Solution:
         * composer dump-autoload
         *
         * only use the below CLI command in development!
         * php artisan migrate:refresh --seed
         */
        $this->call([
            BookablesTableSeeder::class,
            BookingsTableSeeder::class,
            ReviewsTableSeeder::class
        ]);
    }
}
