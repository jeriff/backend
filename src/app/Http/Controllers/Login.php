<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginUser;
use Session;

class Login extends Controller
{
    /**
     * 登录 admin_test/test
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function in(Request $request)
    {
        if (Session::has('user')){
            return ResponseFailJson('用户已登录');
        }

        $username = $request->input('username','');
        $password = $request->input('password','');
        if(empty($username) || empty($password)){
            return ResponseFailJson('用户名或密码必须');
        }

        $login_user = LoginUser::getLoginUserByNameAndPwd($username,$password);
        if (!isset($login_user->id)){
            return ResponseFailJson('用户名或密码错误');
        }

        Session::put('user',$login_user);
        return ResponseSuccessJson($login_user);
    }

    public function out(Request $request)
    {
        if (Session::has('user')){
            Session::flush();
        }

        return ResponseSuccessJson('退出成功');
    }

    public function test()
    {
        $disk = \Storage::disk('qiniu');
        $disk->put();
        $disk->avinfo();die;
        $policy = [
            'callbackUrl' => 'https://hrm.kingnet.com/callback/upload_res',
            'callbackHost' => 'https://hrm.kingnet.com/',
            'callbackBody' => 'key=$(key)&hash=$(etag)',
            'callbackBodyType' => 'application/x-www-form-urlencoded',
            'persistentOps' => 'vsample/jpg/ss/0/t/100/interval/20/pattern/'.\Qiniu\base64_urlSafeEncode('vframe-$(count)'),
            'persistentNotifyUrl' => 'https://hrm.kingnet.com/callback/persistent_res',
            'persistentPipeline' => 'video2pic',
            'fileType' => 0
        ];
        $token = $disk->getDriver()->uploadToken(null,3600,$policy);
        var_dump($token);die;
        //$res = $disk->getDriver()->persistentStatus('z0.5d2ebb4a38b9f31ea6df8a6c');
        //var_dump($res);die;
        //$res = $disk->exists('thumbnail.jpg');
        //var_dump($disk->get('thumbnail.jpg'));
        $res = $disk->avInfo('15633433295787239294.mp4');
        var_dump($res);die;
        $pattern = \Qiniu\base64_urlSafeEncode('vframe-$(count)');
        $res = $disk->getDriver()->persistentFop('15633433295787239294.mp4','vsample/jpg/ss/0/t/100/interval/20/pattern/'.$pattern);
        var_dump($res);
    }
}
