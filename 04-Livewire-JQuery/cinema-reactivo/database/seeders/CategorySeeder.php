<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['CategoryName' => 'Action'],
            ['CategoryName' => 'Adventure'],
            ['CategoryName' => 'Comedy'],
            ['CategoryName' => 'Drama'],
            ['CategoryName' => 'Horror'],
            ['CategoryName' => 'Science Fiction'],
            ['CategoryName' => 'Documentary'],
            ['CategoryName' => 'Animation'],
            ['CategoryName' => 'Fantasy'],
            ['CategoryName' => 'Thriller'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
