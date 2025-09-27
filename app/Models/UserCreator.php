<?php

namespace App\Models;

use App\Traits\ForHumans;
use App\Traits\simpleCRUD;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCreator extends Model
{
    use HasFactory;
    use simpleCRUD;
    use ForHumans;

    protected $fillable = [
        'user_id', 'user_creator_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }
}
