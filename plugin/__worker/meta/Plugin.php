<?php

namespace plugin\__worker\meta;

use plugin\__plugin\Helper;
use plugin\__plugin\PluginBase;
use plugin\__worker\command\HttpWorker;
use plugin\__worker\command\HttpWorkerForWin;
use plugin\__worker\provider;
use think\Cookie;
use think\Request;

class Plugin extends PluginBase
{
    protected function runningInConsole(): void
    {
        Helper::commands(
            HttpWorker::class,
            HttpWorkerForWin::class
        );
    }

    protected function runningInCliServer(): void
    {
        Helper::bindProviders(
            [
                Cookie::class => provider\Cookie::class,
              Request::class => provider\Request::class,
            ]
        );
    }
}
