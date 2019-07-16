<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FileLog
 *
 * @property int $id
 * @property string $key 新生成的文件名
 * @property string $name 文件原名
 * @property int $uid
 * @property string $uname
 * @property string $create_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileLog whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileLog whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileLog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileLog whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileLog whereUname($value)
 * @mixin \Eloquent
 */
class FileLog extends Model
{
    protected $table = "file_log";

    public $timestamps = false;
}
