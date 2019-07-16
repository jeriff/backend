<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LoginUser
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginUser whereUsername($value)
 * @mixin \Eloquent
 */
class LoginUser extends Model
{
    protected $table = "login_user";

    public $timestamps = false;

    protected $hidden = ['password'];

    /**
     * 根据账号密码获取用户
     * @param $username 用户名
     * @param $password 密码
     * @return bool
     */
    public static function getLoginUserByNameAndPwd($username,$password)
    {
        $salt_password = SlatPassword($password);
        return self::where('username',$username)
                    ->where('password',$salt_password)
                    ->first();
    }
}
