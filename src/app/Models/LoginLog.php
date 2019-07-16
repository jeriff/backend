<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LoginLog
 *
 * @property int $id
 * @property string $username
 * @property string $ip
 * @property string $login_time
 * @property int $login_res 登录结果 1 成功 二失败
 * @property string|null $data 请求数据
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginLog whereLoginRes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginLog whereLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginLog whereUsername($value)
 * @mixin \Eloquent
 */
class LoginLog extends Model
{
    protected $table = "login_log";

    public $timestamps = false;
}
