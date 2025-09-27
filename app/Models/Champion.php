<?php

namespace App\Models;

use App\Traits\ForHumans;
use App\Traits\simpleCRUD;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

class Champion extends Authenticatable
{
    use simpleCRUD;
    use ForHumans;

    protected $fillable = [
        'name', 'surname', 'patronymic',
        'coach', 'category', 'weight', 'birth_date',
    ];

    public function getFullNameAttribute(): string
    {
        return sprintf('%s %s', ucfirst($this->surname), ucfirst($this->name));
    }

    public function getFullNameWithPatronymicAttribute(): string
    {
        return sprintf('%s %s %s', ucfirst($this->surname), ucfirst($this->name), ucfirst($this->patronymic));
    }

    /**
     * Возраст участника (вычисляется на лету из birth_date)
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birth_date) return null;
        return Carbon::parse($this->birth_date)->age;
    }

}
