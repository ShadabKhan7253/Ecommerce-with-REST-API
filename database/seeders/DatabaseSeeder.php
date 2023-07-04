<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(App::environment() === 'production') exit();

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // 1. Truncate all the table except 'migrations' table
        $tables = DB::select('SHOW TABLES');
        $key = "Tables_in_".env("DB_DATABASE");

        foreach ($tables as $table) {
            if($table->$key !== 'migrations') {
                DB::table($table->$key)->truncate();
            }
        }

        // 2. Seed the database using Factories
        $numOfUsers = 200;
        $numOfCategories = 30;
        $numOfProducts = 1000;
        $numOfTransactions = 1000;

        User::factory()->count($numOfUsers)->create();

        Category::factory()->count($numOfCategories)->create();

        Product::factory()
            ->count($numOfProducts)
            ->create()
            ->each(function($product) {
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
                $product->categories()->attach($categories);
            });

        Transaction::factory()->count($numOfTransactions)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
