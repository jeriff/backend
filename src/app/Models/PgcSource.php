<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PgcSource
 *
 * @property int $id
 * @property int $pgc_id
 * @property string|null $source 资源地址
 * @property int $sort 排序
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PgcSource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PgcSource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PgcSource query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PgcSource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PgcSource wherePgcId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PgcSource whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PgcSource whereSource($value)
 * @mixin \Eloquent
 */
class PgcSource extends Model
{
    protected $table = "pgc_source";

    public $timestamps = false;

    public static function getSourceByPgcId($id)
    {
        return self::where('pgc_id',$id)
                    ->orderBy('sort','asc')
                    ->get();
    }
}
