<?php

namespace plugin\__plugin;

use plugin\__plugin\command\PluginMake;

class Plugin extends PluginBase
{
    protected function runCli(): void
    {
        Helper::commands(
            command\Plugin::class,
            PluginMake::class
        );
    }
}
