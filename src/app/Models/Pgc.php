<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pgc
 *
 * @property int $id
 * @property string $title 标题
 * @property string $cover 封面
 * @property int $uid 用户编码
 * @property string $uname 用户名
 * @property string $content 文案
 * @property int $status 状态 1 上线 2 下线
 * @property string $create_time 创建时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pgc whereUname($value)
 * @mixin \Eloquent
 */
class Pgc extends Model
{
    protected $table = "pgc";

    public $timestamps = false;
}
