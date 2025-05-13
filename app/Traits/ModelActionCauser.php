<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait ModelActionCauser
{
    protected static function bootModelActionCauser()
    {
        static::creating(function ($model) {
            $tableName = $model->getTable();
            $createdByColumnExists = Schema::hasColumn($tableName, 'created_by');
            if ($createdByColumnExists) {
                $model->created_by = causer_id();
                $model->save(); 
            }
        });

        static::updating(function ($model) {
            $tableName = $model->getTable();
            $updatedByColumnExists = Schema::hasColumn($tableName, 'updated_by');
            if ($updatedByColumnExists) {
                $model->updated_by = causer_id();
                $model->save();
            }
        });

        static::deleting(function ($model) {
            $tableName = $model->getTable();
            $deletedByColumnExists = Schema::hasColumn($tableName, 'deleted_by');
            if ($deletedByColumnExists) {
                $model->deleted_by = causer_id();
                $model->save();
            }
        });
    }
}
