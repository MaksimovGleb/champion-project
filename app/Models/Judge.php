<?php

namespace App\Models;

use App\Traits\ForHumans;
use App\Traits\simpleCRUD;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Judge extends Authenticatable
{
    use simpleCRUD;
    use ForHumans;

    protected $fillable = [
        'position',
        'name', 'surname', 'patronymic',
        'country', 'city', 'category',
    ];

    public function getFullNameAttribute(): string
    {
        return sprintf('%s %s', ucfirst($this->surname), ucfirst($this->name));
    }

    public function getFullNameWithPatronymicAttribute(): string
    {
        return sprintf('%s %s %s', ucfirst($this->surname), ucfirst($this->name), ucfirst($this->patronymic));
    }
}
