<?php

namespace plugin\__entity;

use plugin\__entity\command\Entity;
use plugin\__plugin\Helper;
use plugin\__plugin\PluginBase;

/**
 * @Data: 2022/12/6
 * @Author: WasonCheung
 * @Description: 实体类生成插件
 */
class Plugin extends PluginBase
{
    protected function runCli(): void
    {
        Helper::commands(Entity::class);
    }
}
