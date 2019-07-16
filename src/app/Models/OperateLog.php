<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OperateLog
 *
 * @property int $id
 * @property string $ip
 * @property string $data 请求内容
 * @property string $create_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperateLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperateLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperateLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperateLog whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperateLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperateLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperateLog whereIp($value)
 * @mixin \Eloquent
 */
class OperateLog extends Model
{
    protected $table = "operate_log";

    public $timestamps = false;
}
