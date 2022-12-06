<?php

namespace app\admin\controller;

use app\admin\validate\LoginValidate;

/**
 * @Data: 2022/11/24
 * @Author: WasonCheung
 * @Description: 后台登录
 */
class Login
{
    public function index(): string
    {
        $loginValidate = new LoginValidate();
        $loginValidate->check(request()->param());
        return 'd';
    }
}
