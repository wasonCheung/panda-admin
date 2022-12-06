<?php

namespace plugin\__panda;

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
        // debug
        \define('APP_DEBUG', $this->app->isDebug());

        // 是否在命令行下运行
        \define('RUNNING_IN_CONSOLE', $this->app->runningInConsole());

        // 框架助手函数
        include __DIR__ . DIRECTORY_SEPARATOR . 'helper.php';

        // 注册插件
        (new Starter($this->app))->start();
    }
}
