<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image', 'address', 'phone', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getName($id)
    {
        $data = User::findOrFail($id);
        if($data){
            return $data->name;
        }
        return '';
    }
    public static function getPhoto($id)
    {
        $data = User::findOrFail($id);
        if($data){
            if($data->image != NULL)
            {
                return 'images/'.$data->image;
            }
        }
        return '/theme/images/no-img.jpg';
    }
}
