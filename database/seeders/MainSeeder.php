<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
// Importación de Modelos de Infraestructura
use Src\BC\Author\Infrastructure\Models\AuthorModel;
use Src\BC\Post\Infrastructure\Models\PostModel;
use Src\BC\Comment\Infrastructure\Models\CommentModel;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        // 15 iteraciones para crear 15 autores, 15 posts y 15 comentarios
        for ($i = 1; $i <= 15; $i++) {
            
            // 1. Crear Autor con Password Segura (Hash + Pepper)
            $authorId = (string) Str::uuid();
            AuthorModel::create([
                'id'         => $authorId,
                'first_name' => "Autor_$i",
                'last_name'  => "Apellido_$i",
                'birth_date' => now()->subYears(rand(20, 50))->format('Y-m-d'),
                'email'      => "autor$i@example.com", // Email dinámico para evitar el error Unique
                'password'   => Hash::make("password$i" . config('auth.pepper')) 
            ]);

            // 2. Crear un Post asociado a ese autor
            $postId = (string) Str::uuid();
            PostModel::create([
                'id'           => $postId,
                'author_id'    => $authorId,
                'subject'      => "Título del Post número $i",
                'description'  => "Este es el contenido épico del post escrito por el autor $i.",
                'publish_date' => now()->format('Y-m-d'),
                'status'       => 'published'
            ]);

            // 3. Crear un Comentario asociado al post y al autor
            CommentModel::create([
                'id'           => (string) Str::uuid(),
                'post_id'      => $postId,
                'author_id'    => $authorId, 
                'description'  => "Este es el comentario automático número $i para el post $i",
                'comment_date' => now()->format('Y-m-d'), // Nombre de columna correcto
                'status'       => 'approved'
            ]);
        }
    }
}