<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use Validator;
use Illuminate\Validation\Rule;

class User extends Controller
{
    public function getUserList(Request $request)
    {
        $show_num = (int)$request->input('show_num',30);//每页显示条数 0 不分页
        //$page = (int)$request->input('page',1);//页码数 不分页时 该参数无效
        $search = XssFilter($request->input('search',''));
        $list = MUser::getUserList($search,$show_num);

        return ResponseSuccessJson($list);
    }

    public function editUser(Request $request)
    {
        $id = (int)$request->input('id',0);
        // $name = XssFilter($request->input('name',''));
        // $gender = (int)$request->input('gender',1);
        // $avater = XssFilter($request->input('avater',''));

        $data = $request->only(['name','gender','avater']);

        $rules = [
            'name' => ['required','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u',Rule::unique('user','name')->ignore($id)],
            'gender' => [Rule::in([1, 2])],
            'avater' => ['required','exists:file_log,key']
        ];

        $msg = [
            'name.required' => '用户名参数必须',
            'name.regex' => '用户名只能包含中文，字母，数字和_',
            'name.unique' => '用户名已存在',
            'gender.in' => '性别只可为男或女',
            'avater.required' => '头像参数必须',
            'avater.exists' => '无效的头像',
        ];

        $validator=Validator::make($data,$rules,$msg);
        if($validator->fails()) {
            return ResponseFailJson(array_values($validator->errors()->toArray()));
        }

        $user = MUser::find($id);
        $data['create_time'] = isset($user->id) ? $user->create_time : date('Y-m-d H:i:s');
        $res = MUser::updateOrCreate(['id' => $id],$data);
        return ResponseSuccessJson($res);
    }
}
