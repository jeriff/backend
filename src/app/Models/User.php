<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property int|null $gender 性别 1 女 2 男
 * @property string|null $avatar 头像
 * @property int $status 状态 1 启用 2 禁用
 * @property string|null $create_time 创建时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatus($value)
 * @mixin \Eloquent
 */
class User extends Model
{
    protected $table = "user";

    public $timestamps = false;

    protected $fillable = ['name','gender','avater','create_time'];

    public static function getUserList($search,$show_num)
    {
        $obj = self::where('status',1)
                    ->orderBy('create_time','desc');

        if($search !== ''){
            $obj->where('name','like','%'.$search.'%');
        }

        return $show_num ? $obj->paginate($show_num) : $obj->get();
    }

    public static function getUserByName($name)
    {
        return self::where('name',$name)->first();
    }
}
