<?php

namespace App\Models;

use App;

use App\Enums\UserRoles;
use App\Services\Interfaces\ShortUrl\ShortUrlServiceInterface;
use App\Services\SiteSettings\RoleSettings;
use App\Traits\ForHumans;
use App\Traits\HasRolesAndPermissions;
use App\Traits\simpleCRUD;
use App\Traits\User\Filters;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Faker;

class User extends Authenticatable implements HasMedia, JWTSubject
{
    use HasFactory;
    use Notifiable;
    use HasRolesAndPermissions;
    use simpleCRUD;
    use ForHumans;
    use Filters;
    use InteractsWithMedia;

    protected $fillable = [
        'name', 'surname', 'patronymic',
        'phone', 'email',
        'password', 'avatar', 'remember_token',
        'user_ref_id',
        'marked',
        'comment_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // For JWT Auth
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }

    public function getFullNameAttribute(): string
    {
        return sprintf('%s %s', ucfirst($this->surname), ucfirst($this->name));
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn () => $this
                ?->getFirstMedia('avatars')
                ?->getUrl('thumb-35') ?? '',
        );
    }

    public function getMailAndFullNameAttribute(): string
    {
        return sprintf("%s | %s %s %s",
            ucfirst($this?->email ?? ''),
            ucfirst($this?->surname ?? ''),
            ucfirst($this?->name ?? ''),
            ucfirst($this?->patronymic ?? ''),
        );
    }

    public function getFullNameWithPatronymicAttribute(): string
    {
        return sprintf('%s %s %s', ucfirst($this->surname), ucfirst($this->name), ucfirst($this->patronymic));
    }

    public function updatePassword(string $password, bool $isQuietly = false): self
    {
        $this->password = Hash::make($password);
        if ($isQuietly)
            $this->saveQuietly();
        else
            $this->save();

        return $this;
    }

    public static function generatePassword(): string
    {
        $faker = Faker\Factory::create();
        return $faker->numerify('#####');
    }

    public function creator(): HasOne
    {
        return $this->hasOne(UserCreator::class);
    }

    public function assignCreator($creatorID) : ?UserCreator
    {
        $creator = User::Find($creatorID);

        if ($creator) {
            $newUserCreator = new UserCreator([
                'user_id' => $this->id,
                'user_creator_id' => $creator->id,
            ]);

            $creator = $this->creator ?? $newUserCreator;

            $creator->fill($newUserCreator->attributes);
            $this->creator()->save($creator);

            return $creator;
        }
        $this->creator()->delete();
        return null;
    }

    public function getCreatorName()
    {
        $name = '';
        if (isset($this->creator)) {
            $creator = $this->creator->creator;
            $name = $creator->FullName;
        }

        return $name;
    }

    public function getCreatorID()
    {
        return isset($this->creator) ? $this->creator->creator->id : null;
    }

    public static function decryptReferralUrl($url)
    {
        $shortUrlObject = App::make(ShortUrlServiceInterface::class);

        return $shortUrlObject->fromUrl($url);
    }

    public function isProfileEmpty(): bool
    {
        return
            empty($this->surname) ||
            empty($this->phone);
    }

    public static function FindByPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (!empty($phone) && $phone[0] == '8')
            $phone[0] = '7';

        return self::where('phone', $phone)->first();
    }

    public function oneTimePassword(): HasOne
    {
        return $this->hasOne(OneTimePassword::class);
    }

    public function setOneTimePassword($password): OneTimePassword
    {
        $newPassword = new OneTimePassword(['password' => $password]);
        $this->oneTimePassword()->delete();
        $this->oneTimePassword()->save($newPassword);

        return $newPassword;
    }

    public function updateAvatar(?string $path)
    {
        if ($path) {
            $this->clearMediaCollection('avatars');
            $this->addMedia($path)
                ->preservingOriginal()
                ->toMediaCollection('avatars');
        } else {
            $this->setDefaultAvatar();
        }
    }

    /** Сделать пользователя админом */
    public function makeAdmins()
    {
        $roleClient = Role::firstWhere('slug', UserRoles::UserAdminRoleSlug);
        $this->roles()->attach($roleClient);
    }

    public function setDefaultAvatar()
    {
        $this->clearMediaCollection('avatars');

        $this->addMedia(public_path('/client/img/avatardefault.png'))
            ->preservingOriginal()
            ->toMediaCollection('avatars');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb-35')
            ->fit(Manipulations::FIT_CROP, 35, 35)
            ->sharpen(10);

        $this->addMediaConversion('thumb-160')
            ->fit(Manipulations::FIT_CROP, 160, 160)
            ->sharpen(10);

        $this->addMediaConversion('thumb-100')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->sharpen(10);

        $this->addMediaConversion('thumb-400')
            ->crop(Manipulations::CROP_CENTER, 400, 400);
    }

    public function isAdmin($checkActiveRole = false): bool
    {
        $roles = $this->roles;
        $roleAdmin = Role::Admin();

        if ($checkActiveRole) {
            $activeRole = $this->getActiveRole();

            return $roles->contains($roleAdmin) && $activeRole->id == $roleAdmin->id;
        }

        return $roles->contains($roleAdmin);
    }

    public function getActiveRole(): ?Role
    {
        $roleDefault = $this->roles->sortByDesc('priority')->first();

        $activeRoleId = session('activeRoleId') ?? 0;
        if ($activeRoleId) {
            $activeRole = app(RoleSettings::class)->getRoleById($activeRoleId);

            return $activeRole ?? $roleDefault;
        }

        return $roleDefault;
    }

    public function setActiveRole(?Role $role)
    {
        if ($role)
            session(['activeRoleId' => $role->id]);
    }

    public function getAllRolesName(): string
    {
        $sortedRoles = $this?->roles?->sortBy('priority');

        return implode(', ', $sortedRoles?->pluck('name')?->toArray() ?? []);
    }

    public function notificationUsers()
    {
        return $this->hasMany(NotificationUser::class, 'user_id');
    }

    public function setFavoriteComment($comment_id = null): User
    {
        $this->comment_id = $comment_id;
        $this->save();

        return $this;
    }
}
