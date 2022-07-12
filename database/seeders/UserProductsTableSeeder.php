<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::inRandomOrder()->limit(5)->get();

        foreach($users as $user)
        {
            $product = Product::inRandomOrder()->first();
            $user->products()->attach($product->id, ['quantity' => rand('1', '50')]);
        }
    }
}
