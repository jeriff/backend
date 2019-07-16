<?php

namespace App\Http\Controllers;

use App\Models\FileLog;
use App\Models\PgcSource;
use Illuminate\Http\Request;
use App\Models\Pgc;
use Validator;
use DB;

class Data extends Controller
{
    public function getPgcList(Request $request)
    {
        $show_num = (int)$request->input('show_num',30);//每页显示条数 0 不分页
        //$page = (int)$request->input('page',1);//页码数 不分页时 该参数无效
        $search = XssFilter($request->input('search',''));
        $status = (int)$request->input('status',1);//pgc状态 1 上线 2 下线 0 全部
        $list = Pgc::getPgcList($search,$show_num,$status);
        $list = $this->getPgcDetail($list);
        return ResponseSuccessJson($list);
    }

    public function getDetail(Request $request)
    {
        $id = (int)$request->input('id',0);
        $pgc = Pgc::find($id);
        $pgc = $this->getPgcDetail($pgc);
        return ResponseSuccessJson($pgc);
    }

    public function editPgc(Request $request)
    {
        $id = (int)$request->input('id',0);

        $data = $request->only(['title','cover','content','label','uid']);

        $rules = [
            'uid' => ['required','exists:user,id'],
            'title' => ['required'],
            'cover' => ['required'],
            'content' => ['required'],
            'label' => ['required'],
        ];

        $msg = [
            'title.required' => '标题参数必须',
            'cover.required' => '封面参数必须',
            'content.required' => '文案内容必须',
            'label.required' => '标签参数必须',
            'uid.required' => '用户参数必须',
            'uid.exists' => '无效用户',
        ];

        $validator = Validator::make($data,$rules,$msg);
        if($validator->fails()) {
            return ResponseFailJson(array_values($validator->errors()->toArray()));
        }

        $source = XssFilter($request->input('source',[]));
        if(empty($source) || !is_array($source)){
            return ResponseFailJson('无效素材资源');
        }

        $upload_type = 0;//上传类型 0 未知 1 图片 2 视频
        $upload_num = 0;//上传数量
        foreach($source as $v){
            $file = FileLog::getByKey($v);
            if(!isset($file->id)){
                return ResponseFailJson('无效资源数据');
            }

            $arr_name = explode('.', $v);
            if (count($arr_name) == 0) {
                return ResponseFailJson('文件名格式错误:'.$v);
            }

            $file_type = strtolower(array_pop($arr_name));

            $tmp_upload_type = in_array($file_type,Files::videoType) ? 2 : 1;
            if($upload_type != 0 && $upload_type != $tmp_upload_type){
                return ResponseFailJson('图片和视频不可混传');
            }
            $upload_type = $tmp_upload_type;

            $upload_num++;
        }

        if(($upload_type == 1 && $upload_num > 9) || ($upload_type == 2 && $upload_num > 1)){
            return ResponseFailJson('上传数量超限');
        }

        DB::beginTransaction();
        $pgc = Pgc::find($id);
        if(!isset($pgc->id)){
            $data['create_time'] = date('Y-m-d H:i:s');
        }
        $user = \App\Models\User::find($data['uid']);
        $data['uname'] = $user->name;

        $pgc = Pgc::updateOrCreate(['id' => $id],$data);
        $id = $pgc->id;
        PgcSource::where('pgc_id',$id)->delete();
        $sort = 1;
        foreach ($source as $v){
            PgcSource::insert([
                'pgc_id' => $id,
                'source' => $v,
                'sort' => $sort
            ]);
            $sort++;
        }
        DB::commit();
        $pgc = $this->getPgcDetail($pgc);
        return ResponseSuccessJson($pgc);
    }

    public function changeStatus(Request $request)
    {
        $id = (int)$request->input('id',0);
        $pgc = Pgc::find($id);
        if(!isset($pgc->id)){
            return ResponseFailJson('无效数据');
        }

        $status = (int)$request->input('status',1);
        if(!in_array($status,[1,2])){
            return ResponseFailJson('无效状态');
        }

        if($status == $pgc->status){
            return ResponseFailJson('切换状态和当前状态一致');
        }

        $pgc->status = $status;
        $pgc->save();

        $pgc = $this->getPgcDetail($pgc);
        return ResponseSuccessJson($pgc);
    }

    protected function getPgcDetail($pgc){
        if($pgc instanceof Pgc){
            $pgc->source = PgcSource::getSourceByPgcId($pgc->id);
        }elseif(is_array($pgc) || $pgc instanceof \Traversable){
            foreach ($pgc as $k => $v){
                if($v instanceof Pgc){
                    $pgc[$k]->source = PgcSource::getSourceByPgcId($v->id);
                }elseif(is_array($v) && isset($v['id'])){
                    $pgc[$k]['source'] = PgcSource::getSourceByPgcId($v['id']);
                }
            }
        }
        return $pgc;
    }
}
