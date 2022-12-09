<?php

namespace plugin\__kernel;

use plugin\__plugin\Starter;
use think\Service;

/**
 * @Data: 2022/12/2
 * @Author: WasonCheung
 * @Description: 框架服务引导
 */
class PandaStarter extends Service
{
    public function register(): void
    {
        // 框架助手函数
        include_once __DIR__ . DIRECTORY_SEPARATOR . 'helper.php';

        // 注册插件
        (new Starter($this->app))->start();
    }
}
