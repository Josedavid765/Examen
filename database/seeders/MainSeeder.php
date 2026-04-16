<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Src\BC\Author\Infrastructure\Models\AuthorModel;
use Src\BC\Post\Infrastructure\Models\PostModel;
use Src\BC\Comment\Infrastructure\Models\CommentModel;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 2; $i <= 15; $i++) {
            // 1. Crear Autor
            $authorId = (string) Str::uuid();
            AuthorModel::create([
                'id' => $authorId,
                'first_name' => "Autor_$i",
                'last_name' => "Apellido_$i",
                'birth_date' => now()->subYears(rand(20, 50))->format('Y-m-d'),
                'email' => "autor$i@example.com",
                'password' => "password$i" // Sin cifrar como pediste
            ]);

            // 2. Crear Post para este autor
            $postId = (string) Str::uuid();
            PostModel::create([
                'id' => $postId,
                'author_id' => $authorId,
                'subject' => "Título del Post $i",
                'description' => "Contenido épico del post número $i...",
                'publish_date' => now()->format('Y-m-d'),
                'status' => 'published'
            ]);

            // 3. Crear Comentario para este post
            CommentModel::create([
                'id' => (string) Str::uuid(),
                'post_id' => $postId,
                'author_id' => $authorId, // El mismo autor comenta su post
                'description' => "Este es el comentario automático número $i",
                'comment_date' => now()->format('Y-m-d'),
                'status' => 'approved'
            ]);
        }
    }
}