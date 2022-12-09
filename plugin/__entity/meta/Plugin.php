<?php

namespace plugin\__entity\meta;

use plugin\__entity\command\Entity;
use plugin\__plugin\Helper;
use plugin\__plugin\PluginBase;

/**
 * @Data: 2022/11/21
 * @Author: WasonCheung
 * @Description: 数据库管理插件
 */
class Plugin extends PluginBase
{
    protected function runningInConsole(): void
    {
        Helper::commands(
            Entity::class, // 实体类生成
        );
    }
}
