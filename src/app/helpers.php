<?php
//全局函数
if (!function_exists('ResponseSuccessJson')) {
    /**
     * json成功返回
     * @param  string
     */
    function ResponseSuccessJson($anyInfo)
    {
        $out = [
            'code' => 1,
            'info' => $anyInfo
        ];

        return response()->json($out);
    }
}

if (!function_exists('ResponseFailJson')) {
    /**
     * json失败返回
     * @param  string
     */
    function ResponseFailJson($anyInfo)
    {
        $out = [
            'code' => 0,
            'info' => $anyInfo
        ];

        return response()->json($out);
    }
}

if (!function_exists('SlatPassword')) {
    /**
     * json失败返回
     * @param  string
     */
    function SlatPassword($pwd)
    {
        return md5(md5($pwd).env('SLAT'));
    }
}

if (!function_exists('XssFilter')) {
    /**
     * xss过滤
     * @param  array $input 需要过滤的数组
     * @return array
     */
    function XssFilter($input)
    {
        if (is_array($input)) {
            if (sizeof($input)) {
                foreach ($input as $key => $value) {
                    if (is_array($value) && sizeof($value)) {
                        $input[$key] = XssFilter($value);
                    } else {
                        if (!empty($value)) {
                            $input[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
                        }
                    }
                }
            }
            return $input;
        }
        return htmlentities($input, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('XssDecode')) {
    /**
     * xss顾虑还原
     * @param  array $input 需要还原的数组
     * @return array
     */
    function XssDecode($input)
    {
        if (is_array($input)) {
            if (sizeof($input)) {
                foreach ($input as $key => $value) {
                    if (is_array($value) && sizeof($value)) {
                        $input[$key] = XssDecode($value);
                    } else {
                        if (!empty($value)) {
                            if(is_string($value)){
                                $input[$key] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
                            }else{
                                $input[$key] = $value;
                            }
                        }
                    }
                }
            }
            return $input;
        }
        if(is_string($input)){
            return html_entity_decode($input,ENT_QUOTES,'UTF-8');
        }else{
            return $input;
        }
    }
}