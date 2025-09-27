<?php

namespace App\Models;

use App\Services\SiteSettings\PermissionSettings;
use App\Traits\ForHumans;
use App\Traits\simpleCRUD;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 *
 * @method static \Database\Factories\PermissionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends Model
{
    use HasFactory;
    use simpleCRUD;
    use ForHumans;

    protected $fillable = [
        'name', 'slug',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function users()
    {
        return $this->BelongsToMany(User::class);
    }

    /** Standard */
    public static function juniorStandard()
    {
        return app(PermissionSettings::class)->getStandardPermission();
    }

    public static function middleStandard()
    {
        return app(PermissionSettings::class)->getMiddleStandardPermission();
    }

    public static function seniorStandard()
    {
        return app(PermissionSettings::class)->getSeniorStandardPermission();
    }

    /** General */
    public static function juniorGeneral()
    {
        return app(PermissionSettings::class)->getGeneralPermission();
    }

    public static function middleGeneral()
    {
        return app(PermissionSettings::class)->getMiddleGeneralPermission();
    }

    public static function seniorGeneral()
    {
        return app(PermissionSettings::class)->getSeniorGeneralPermission();
    }

    /** Bfl */
    public static function juniorBFL()
    {
        return app(PermissionSettings::class)->getBflPermission();
    }

    public static function middleBFL()
    {
        return app(PermissionSettings::class)->getMiddleBFLPermission();
    }

    public static function seniorBFL()
    {
        return app(PermissionSettings::class)->getSeniorBFLPermission();
    }

    /** Tax */
    public static function juniorTax()
    {
        return app(PermissionSettings::class)->getTaxPermission();
    }

    public static function middleTax()
    {
        return app(PermissionSettings::class)->getMiddleTaxPermission();
    }

    public static function seniorTax()
    {
        return app(PermissionSettings::class)->getSeniorTaxPermission();
    }
}
