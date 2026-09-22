<?php

namespace Database\Seeders;

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
        // Categories first: ProductSeeder files its demo products against the leaf
        // categories this creates.
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
    }
}
