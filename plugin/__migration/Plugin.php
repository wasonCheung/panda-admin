<?php

namespace plugin\__migration;

use plugin\__plugin\Base;
use plugin\__plugin\Helper;
use think\migration\Creator;

/**
 * @Data: 2022/11/21
 * @Author: WasonCheung
 * @Description: 数据库迁移工具
 */
class Plugin extends Base
{
    protected function runCli(): void
    {
        Helper::bindProviders(
            [Creator::class => \plugin\__migration\Creator::class]
        );
    }
}
