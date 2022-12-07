<?php

namespace plugin\__worker\command;

use plugin\__worker\monitor\WinMonitor;
use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use think\facade\Config;

/**
 * Worker 命令行类
 */
class HttpWorkerForWin extends Command
{
    public function configure(): void
    {
        $this->setName('panda:http-worker-win')
            ->addOption('daemonize', 'd', Option::VALUE_NONE, 'run the worker server in daemon mode.')
            ->addOption('module', 'm', Option::VALUE_OPTIONAL, 'the app of worker server.')
            ->setDescription('http-worker-win');
    }

    public function execute(Input $input, Output $output): int
    {
        if (DIRECTORY_SEPARATOR !== '\\') {
            $output->writeln('此命令只能在Windows平台下运行');
            return false;
        }

        $monitorConfig = Config::get('__worker.monitor');
        $run = 'php think panda:http-worker';
        $daemonize = $this->input->getOption('daemonize');
        $moduleName = $this->input->getOption('module') ?: 'auto';

        if ($daemonize) {
            $run .= ' -d';
        }

        if ($moduleName) {
            $run .= ' -m ' . $moduleName;
        }
        (new WinMonitor($this->app->getRootPath(), $run, $monitorConfig))->run();
        return true;
    }
}
