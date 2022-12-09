<?php

namespace plugin\__kernel\exception;

use plugin\__kernel\tools\Code;
use think\facade\Lang;

class BaseException extends \Exception
{
    /**
     * @param string $lang 多语言错误信息
     * @param array $vars 参数
     */
    public function __construct(string $lang, ...$vars)
    {
        // 错误编码生成
        $code = Code::make($lang);
        // 多语言信息获取
        $lang = Lang::get($lang, $vars);
        parent::__construct($lang, $code);
    }
}
