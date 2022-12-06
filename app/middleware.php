<?php

use think\middleware\AllowCrossDomain;
use think\middleware\LoadLangPack;
use think\middleware\SessionInit;

return [
    // 跨域请求支持
    AllowCrossDomain::class,
    // 多语言自动加载
    LoadLangPack::class,
    // session 初始化
    SessionInit::class,
];
