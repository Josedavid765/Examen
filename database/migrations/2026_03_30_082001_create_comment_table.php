<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('description'); // Cambiado de 'content' a 'description' para que coincida con tu Entidad
            $table->uuid('author_id');
            $table->string('status');    // Faltaba esta columna
            $table->uuid('post_id');
            $table->date('comment_date'); // Faltaba esta columna
            
            // Si quieres usar los timestamps de Laravel (created_at, updated_at) déjalos, 
            // pero recuerda que tu modelo CommentModel los tiene en false.
            $table->timestamps();

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            $table->foreign('author_id')
                ->references('id')
                ->on('authors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('comments');
}
};
