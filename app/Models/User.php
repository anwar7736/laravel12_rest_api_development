<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\ModelActionCauser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, ModelActionCauser;

    protected $guarded = ['id'];
    protected $appends = ['image_url'];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getImageUrlAttribute()
    {
        $image_path = "";
        if ($this->image->count()) {
            $image_path = asset('storage/images') . '/' . $this->image->image;
        }

        return $image_path;
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->select('id', 'image', 'alt_text');
    }

    public function creator()
    {
        return $this->belongsTo(self::class, 'created_by', 'id');
    }

    public function updator()
    {
        return $this->belongsTo(self::class, 'updated_by', 'id');
    }

    public function deletor()
    {
        return $this->belongsTo(self::class, 'deleted_by', 'id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
