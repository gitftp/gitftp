<?php

namespace App\Models;

use App\Exceptions\UserException;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model
{

    public const groupAdmin = 1;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'username',
        'password',
        'created_at',
        'updated_at',
        'email',
        'last_login',
        'login_hash',
        'profile_fields',
        'group',
    ];
    protected $hidden = [ 'password' ];
    protected $primaryKey = 'user_id';

    public static function generateToken($userId){
        $token = md5(time());
        return self::query()->where([
            'user_id' => $userId
        ])->update([
            'last_login' => '',
            'login_hash' => $token,
        ]);
    }

    public static function removeToken($userId){
        return self::query()->where([
            'user_id' => $userId,
        ])->update([
            'login_hash' => '',
        ]);
    }

    public static function create(
        $email, $password
    ){
        $existingUser = self::query()->where([
            'email' => $email,
        ])->get();
        if($existingUser->count()){
            throw new UserException("A user with email $email already exists.");
        }

        $a = self::query()->insert([
            'username' => '',
            'email' => $email,
            'password' => self::hash($password),
            'group' => self::groupAdmin,
        ]);
        return Helper::getLastInsertId();
    }

    public static function hash($p){
        // need a better hash
        return md5($p);
    }

}
