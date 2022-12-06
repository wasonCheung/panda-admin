<?php

namespace plugin\__plugin\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\facade\Config;
use util\FileUtil;

class PluginMake extends Command
{
    public function configure(): void
    {
        $this->setName('panda:plugin-make')
            ->addArgument('name', Argument::REQUIRED, '插件名')
            ->setDescription('创建插件');
    }

    protected function execute(Input $input, Output $output): bool
    {
        $name = $input->getArgument('name');
        if (empty($name)) {
            $output->writeln("<error>插件名不得为空:{$name}</error>");
            return false;
        }
        $rootPath = Config::get('panda.plugin_path');
        $namespace = Config::get('panda.plugin_namespace');
        $pluginPath = $rootPath . $name . DIRECTORY_SEPARATOR;

        if (is_dir($pluginPath)) {
            $output->writeln("<error>插件已存在:{$name}</error>");
            return false;
        }

        $stubsPath = __DIR__ . '/../stubs/';
        // 创建插件目录
        FileUtil::makedir($pluginPath);
        // 创建info
        FileUtil::makefile(
            $pluginPath . 'meta' . DIRECTORY_SEPARATOR . 'info.php',
            file_get_contents($stubsPath . 'info.stubs')
        );
        // 创建配置目录
        FileUtil::makefile(
            $pluginPath . 'config' . DIRECTORY_SEPARATOR . "$name.php",
            file_get_contents($stubsPath . 'config.stubs')
        );
        // 创建多语言目录
        FileUtil::makefile(
            $pluginPath . 'lang' . DIRECTORY_SEPARATOR . 'zh-cn.php',
            file_get_contents($stubsPath . 'config.stubs')
        );
        // 创建plugin类
        $pluginContent = file_get_contents($stubsPath . 'Plugin.stubs');
        $pluginContent = str_replace('{namespace}', $namespace . "\\$name", $pluginContent);
        FileUtil::makefile(
            $pluginPath . 'Plugin.php',
            $pluginContent
        );
        $output->writeln("<error>创建成功:{$name}</error>");
        return true;
    }
}
