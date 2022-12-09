<?php

namespace plugin\__plugin\meta;

use plugin\__plugin\command;
use plugin\__plugin\command\PluginMake;
use plugin\__plugin\Helper;
use plugin\__plugin\PluginBase;

class Plugin extends PluginBase
{
    protected function runningInConsole(): void
    {
        Helper::commands(
            command\Plugin::class,
            PluginMake::class
        );
    }
}
