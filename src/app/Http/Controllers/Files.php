<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileLog;
use Session;
use DB;

class Files extends Controller
{
    /**
     *允许上传文件大小
     */
    const  fileSize = 500000000;

    const allowFileType = ['jpg','jpeg','png','mp4'];

    const videoType = ['mp4'];

    const picType = ['jpg','jpeg','png'];

    /**
     * 上传多个文件
     *
     * @param Request $request
     * @throws \Exception
     */
    public function multipleUploadFile(Request $request)
    {
        $file = $request->file('uploadFile');

        if (!is_array($file)) {
            return ResponseFailJson('参数错误');
        }

        $uploadType = 0;//上传类型 0 未知 1 图片 2 视频
        $uploadNum = 0;//上传数量
        $new_ = [];
        foreach ($file as $k => $val) {
            $name = $val->getClientOriginalName();

            $size = $val->getSize();
            if ($size > self::fileSize) {
                return ResponseFailJson('最大只能上传500m大小的文件');
            }

            $arrName = explode('.', $name);
            if (count($arrName) == 0) {
                return ResponseFailJson('文件名格式错误:'.$name);
            }

            $arrFileType = self::allowFileType;
            $fileType = strtolower(array_pop($arrName));
            if(!in_array($fileType,$arrFileType)){
                return ResponseFailJson('文件类型错误,只支持的文件类型为：' . join(',', $arrFileType));
            }

            $tmpUploadType = in_array($fileType,self::videoType) ? 2 : 1;
            if($uploadType != 0 && $uploadType != $tmpUploadType){
                return ResponseFailJson('图片和视频不可混传');
            }

            $uploadNum++;
            $tmp_data[$k] = [
                'name' => $name,
                'arrName' => $arrName,
                'fileType' => $fileType
            ];
        }

        if(($uploadType == 1 && $uploadNum > 9) || ($uploadType == 2 && $uploadNum > 1)){
            return ResponseFailJson('上传数量超限');
        }

        $res = [];
        $disk = \Storage::disk('qiniu');
        $policy = [
            'callbackUrl' => 'https://hrm.kingnet.com/callback/upload_res',
            'callbackHost' => '',
            'callbackBody' => 'key=$(key)&hash=$(etag)',
            'callbackBodyType' => 'application/x-www-form-urlencoded',
            'persistentOps' => 'vsample/jpg/ss/0/t/100/interval/20/pattern/'.\Qiniu\base64_urlSafeEncode('vframe-${key}/$(count)'),
            'persistentNotifyUrl' => 'https://hrm.kingnet.com/callback/persistent_res',
            'persistentPipeline' => 'video2pic',
            'fileType' => 0
        ];
        $token = $disk->getDriver()->uploadToken(null,3600,$policy);
        $disk->getDriver()->withUploadToken($token);
        DB::beginTransaction();
        foreach ($file as $k => $val){
            $name = $tmp_data[$k]['name'];
            $arrName = $tmp_data[$k]['arrName'];
            $fileType = $tmp_data[$k]['fileType'];

            $newName = sprintf('%d%d.%s', time(), mt_rand(1000000000, 9999999999), $fileType);
            $res = $disk->getDriver()->write($newName,$val->getPathname());
            var_dump($res);die;
            try {

                $uploadRes = $disk->putFileAs('/',$val,$newName);
                if($uploadRes){
                    $res[] = ['key' => $newName, 'name' => $name];
                    FileLog::insert([
                        'key' => $newName,
                        'name' => htmlentities($name, ENT_QUOTES, 'UTF-8'),
                        'uid' => Session::get('user')->id,
                        'uname' => Session::get('user')->username,
                        'create_time' => date('Y-m-d H:i:s')
                    ]);
                }else{
                    DB::rollBack();
                    return ResponseFailJson('文件上传到云失败！');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return ResponseFailJson('保存文件索引失败！');
            }
        }
        DB::commit();

        return ResponseFailJson($res);
    }

    public function downloadFile(Request $request)
    {
        $key = XssFilter($request->input('key',''));

        $disk = \Storage::disk('qiniu');
        if($disk->exists($key)){
            $disk->download($key)->send();
            exit;
        }else{
            return ResponseFailJson('文件不存在');
        }
    }

    public function getVideoPic(Request $request)
    {
        //TODO 根据key获取video数据 调用7牛云接口获取图片并返回 缓存图片下次调用不用揭晓
    }
}
