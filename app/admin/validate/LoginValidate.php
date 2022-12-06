<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

/**
 * @Data: 2022/11/24
 * @Author: WasonCheung
 * @Description: 登录验证器
 */
class LoginValidate extends Validate
{
    protected $failException = true;

    protected $rule = [
        'username' => 'require|regex:^[a-zA-Z][a-zA-Z0-9_]{2,15}$',
        'password' => 'require|regex:^(?!.*[&<>"\'\n\r]).{6,32}$',
        'captcha' => 'require|captcha',
    ];

    protected $message = [
        'username.require' => ['code' => 10000, 'msg' => 'admin/validusername/require']
    ];
}
