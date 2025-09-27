<?php

namespace App\Models;

use App\Traits\ForHumans;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory, ForHumans;

    protected $fillable = ['name', 'title', 'content'];
}
