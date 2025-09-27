<?php

namespace App\Models;

use App\Enums\UserRoles;
use App\Services\SiteSettings\RoleSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Role guests()
 * @method static \Illuminate\Database\Eloquent\Builder|Role admins()

 * @method static \Illuminate\Database\Eloquent\Builder|Role Guest()
 * @method static \Illuminate\Database\Eloquent\Builder|Role Admin()
 *
 * @method static \Database\Factories\RoleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()

 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereSlug($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'slug', 'priority',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->BelongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->BelongsToMany(Permission::class);
    }

    /* L O C A L  S C O U P E S */

    public function scopeGuests($query)
    {
        return $query->with('users')->where('id', UserRoles::USER_GUEST)->firstOrFail();
    }

    public function scopeAdmins($query)
    {
        return $query->with('users')->where('id', UserRoles::USER_ADMIN)->firstOrFail();
    }

    public function scopeUserByRole($query, $role)
    {
        return $query->with('users')->where('id', $role)->firstOrFail();
    }

    public function scopeAdmin()
    {
        return app(RoleSettings::class)->getAdminRole();
    }

    public function isAdmin(): bool
    {
        return app(RoleSettings::class)->getAdminRole()->id === $this->id;
    }

}
