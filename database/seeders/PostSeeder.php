<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::latest()->get();
        $users = User::latest()->get();
        $number = 20;

        for($i = 0; $i <= $number; $i++ )
        {
            Post::create([
                'title' => 'Post '.$i,
                'short_description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatem, eius?'.$i,
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
