<?php

namespace plugin\__kernel\meta;

use plugin\__plugin\Helper;
use plugin\__plugin\PluginBase;
use think\migration\Creator;

/**
 * @Data: 2022/11/21
 * @Author: WasonCheung
 * @Description: 数据库管理插件
 */
class Plugin extends PluginBase
{
    protected function runningInConsole(): void
    {
        Helper::bindProviders([
            Creator::class => \plugin\__kernel\provider\Creator::class,
        ]);
    }
}
