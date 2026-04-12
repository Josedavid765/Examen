<?php

namespace Src\BC\Comment\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BC\Post\Infrastructure\Models\PostModel;

class CommentModel extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id',
        'description',
        'author_id',
        'status',
        'post_id',
        'comment_date'
    ];

    public function author()
    {
        return $this->belongsTo(\Src\BC\Author\Infrastructure\Models\AuthorModel::class, 'author_id');
    }

    protected static function booted(): void
    {
        static::created(function ($comment) {
            PostModel::where('id', $comment->post_id)->increment('num_comments');
        });

        static::deleted(function ($comment) {
            PostModel::where('id', $comment->post_id)->decrement('num_comments');
        });
    }
}