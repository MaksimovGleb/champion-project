<?php

namespace App\Traits;

use Carbon\Carbon;

trait ForHumans
{
    public function createdAtForHumans()
    {
        return $this->created_at ? $this->created_at->locale('ru')->diffForHumans() : '';
    }

    public function updatedAtForHumans()
    {
        return $this->updated_at ? $this->updated_at->locale('ru')->diffForHumans() : '';
    }

    public function createdAtFormat()
    {
        return $this->created_at ? Carbon::parse($this->created_at)->format('d.m.Y H:i:s') : '';
    }

    public function updatedAtFormat()
    {
        return $this->updated_at ? Carbon::parse($this->updated_at)->format('d.m.Y H:i:s') : '';
    }

    public function getAllPermissionsNameString(): string
    {
        $result = '';
        $permissions = $this->permissions->pluck('name')->toArray();
        //dd($p);
        if ($permissions) {
            $result = implode(', ', $permissions);
        }

        return $result;
    }
}
