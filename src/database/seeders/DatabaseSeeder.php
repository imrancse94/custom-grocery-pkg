<?php

namespace Imrancse94\Grocery\database\seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Imrancse94\Grocery\app\Models\GroceryUser;
use Imrancse94\Grocery\app\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        GroceryUser::create([
            'name'=> 'Admin',
            'email'=> 'user@admin.com',
            'password'=> Hash::make('123456'),
            'role'=>'admin'
        ]);

        GroceryUser::create([
            'name'=> 'Manager',
            'email'=> 'user@manager.com',
            'password'=> Hash::make('123456'),
            'role'=>'manager'
        ]);

        Product::create([
            'name'=> 'Product 1',
        ]);
        Product::create([
            'name'=> 'Product 2',
        ]);
    }
}
