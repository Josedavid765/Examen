<?php

namespace Src\bc\Comment\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'description',
        'author_id',
        'status',
        'post_id',
        'comment_date',
    ];
    
    public $timestamps = false; 
}
