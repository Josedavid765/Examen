<?php

namespace Src\bc\Author\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorModel extends Model
{
    protected $table = 'authors';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'birth_date'
    ];
}
