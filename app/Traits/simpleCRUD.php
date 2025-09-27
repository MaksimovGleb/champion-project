<?php

namespace App\Traits;

trait simpleCRUD
{
    protected static function Add($fields, $isQuietly = false)
    {
        $obj = new static();
        $obj->fill($fields);
        if ($isQuietly == true) {
            $obj->saveQuietly();
        } else {
            $obj->save();
        }

        return $obj;
    }

    protected static function Edit($fields, $id, $isQuietly = false)
    {
        //$fields = array_filter($fields);
        $obj = static::FindOrFail($id);
        $obj->fill($fields);
        if ($isQuietly == true) {
            $obj->saveQuietly();
        } else {
            $obj->save();
        }
        return $obj;
    }
}
