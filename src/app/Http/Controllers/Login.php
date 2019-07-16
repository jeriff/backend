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
        $str = '1皮皮（';
        $reg = '';
        $res = preg_match($reg,$str,$arr);
        var_dump($arr);
    }
}
