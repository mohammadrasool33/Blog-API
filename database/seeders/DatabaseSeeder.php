<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create()->each(function ($user) {
            $user->posts()->saveMany(\App\Models\Post::factory(3)->make())->each(function ($post) {
                $post->comments()->saveMany(\App\Models\Comment::factory(2)->make());
            });
        });
    }
}
