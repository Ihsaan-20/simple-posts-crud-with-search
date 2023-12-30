<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Php', 'Javascript', 'Typescript', 'Reactjs'];

        foreach($categories as $cate)
        {
            Category::create([
                'name' => $cate
            ]);
        }
    }
}
