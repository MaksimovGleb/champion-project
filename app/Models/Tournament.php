<?php

namespace App\Models;

use App\Traits\ForHumans;
use App\Traits\simpleCRUD;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tournament extends Authenticatable
{
    use simpleCRUD;
    use ForHumans;

    protected $fillable = [
        'title', 'participants', 'grid', 'judges'
    ];

    protected $casts = [
        'grid' => 'array',
        'participants' => 'array',
        'judges' => 'array'
    ];
}
