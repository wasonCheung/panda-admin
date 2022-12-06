<?php

namespace plugin\__plugin\command;

use plugin\__plugin\Manager;
use plugin\__plugin\Base as PluginBase;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\facade\Config;

/**
 * @Data: 2022/12/2
 * @Author: WasonCheung
 * @Description: 插件发布
 */
class Plugin extends Command
{
    public function configure(): void
    {
        $this->setName('panda:plugin')
            ->addArgument('name', Argument::REQUIRED, '插件名')
            ->addArgument('action', Argument::REQUIRED, 'enable|disable|install|uninstall|update|remove')
            ->setDescription('插件管理');
    }

    protected function execute(Input $input, Output $output): bool
    {
        $action = $input->getArgument('action');
        $name = $input->getArgument('name');

        // 实例化插件
        $plugin = Manager::getWith(
            Config::get('panda.plugin_path'),
            Config::get('panda.plugin_namespace'),
            $name,
            true
        );

        if (!$plugin instanceof PluginBase) {
            $output->writeln("<error>插件不存在:{$name}</error>");
            return false;
        }

        if (method_exists($plugin, $action)) {
            foreach ($plugin->getInfo() as $key => $value) {
                $output->writeln("$key: $value");
            }
            $plugin->{$action}();
            $output->writeln("[ {$plugin->name} ] $action 成功");
            return true;
        }

        $output->writeln("<error>不支持此操作:{$action}</error>");
        return false;
    }
}
