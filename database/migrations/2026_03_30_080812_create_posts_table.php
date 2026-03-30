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
    Schema::create('posts', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('author_id');
        
        $table->string('subject');
        $table->text('description');
        $table->timestamp('publish_date');
        $table->string('status');
        $table->integer('num_comments')->default(0);
        $table->timestamps();

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
        Schema::dropIfExists('posts');
    }
};
