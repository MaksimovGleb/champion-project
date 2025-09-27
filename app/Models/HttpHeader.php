<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HttpHeader extends Model
{
    use HasFactory;

    protected $table = 'http_headers';

    protected $fillable = [
        'ip', 'user_id', 'headers',
    ];
}
