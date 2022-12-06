<?php

namespace plugin\workerman;

use plugin\__plugin\PluginBase;
use plugin\__plugin\Helper;
use plugin\workerman\command\Worker;
use think\Cookie;
use think\Request;

class Plugin extends PluginBase
{
    protected function runInCli(): void
    {
        Helper::commands(
            Worker::class
        );
    }

    protected function runInCgi(): void
    {
        Helper::bindProviders(
            [
                Cookie::class => provider\Cookie::class,
                Request::class => provider\Request::class,
            ]
        );
    }
}
