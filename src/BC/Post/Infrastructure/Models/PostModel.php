<?php

namespace Src\BC\Post\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'author_id',
        'subject',
        'description',
        'publish_date',
        'status',
        'num_comments',
    ];

    public $timestamps = true; 
}