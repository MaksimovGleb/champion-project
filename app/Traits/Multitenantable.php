<?php

namespace App\Traits;

//https://laravel.demiart.ru/prostaya-multitenantnost-v-laravel-cherez-trait/
//https://laravelnews.ru/20-khitrostey-v-laravel-eloquent-o-kotorykh-vy-ne-znali
//https://habr.com/ru/post/344728/
//https://laravel.demiart.ru/guide-to-roles-and-permissions/

trait Multitenantable
{
    protected static function bootMultitenantable()
    {
        if (auth()->check()) {
            static::creating(function ($model) {
                $model->user_id = auth()->id();
            });
        }
    }
}
