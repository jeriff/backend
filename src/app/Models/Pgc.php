<?php

namespace App\Models;

use function foo\func;
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

    protected $fillable = ['title','cover','uid','uname','content','create_time','label'];

    public static function getPgcList($search,$show_num,$status)
    {
        $obj = self::orderBy('create_time','desc');

        if($status){
            $obj->where('status',$status);
        }

        if($search !== ''){
            $obj->where(function($query)use($search){
                $query->where('title','like','%'.$search.'%')
                    ->orWhere('label','like','%'.$search.'%');
            });
        }

        return $show_num ? $obj->paginate($show_num) : $obj->get();
    }
}
