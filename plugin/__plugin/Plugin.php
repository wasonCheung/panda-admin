<?php

namespace plugin\__plugin;

use plugin\__plugin\command\PluginMake;

class Plugin extends Base
{
    protected function runCli(): void
    {
        Helper::commands(
            command\Plugin::class,
            PluginMake::class
        );
    }
}
