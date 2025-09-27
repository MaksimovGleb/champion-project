<?php

namespace App\Models;

use App\Traits\simpleCRUD;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    use simpleCRUD;

    const REGION_TYPE_LOCATION = 0;
    const REGION_TYPE_WORKING = 1;

    protected $fillable = ['user_id', 'kladrId', 'type', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function getShortRegionKladr()
    {
        return substr($this->kladrId, 0, 2);
    }

    /** Проверяет, входит ли город пользователя $who в рабочий регион $user */
    public static function isMyWorksRegions(User $user, ?User $who): bool
    {
        if ($who == null || $who->region == null)
            return false;

        $allowedRegionPattern = $user?->workingRegions->pluck('kladrId')->map(function ($kladrId){
            return substr($kladrId, 0,2);
        })->toArray();

        return in_array(substr($who->region->kladrId, 0,2), $allowedRegionPattern);
    }
}
