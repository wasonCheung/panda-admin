<?php

namespace plugin\__worker\command;

use plugin\__worker\monitor\LinuxMonitor;
use plugin\__worker\worker\HttpWorker as HttpWorkerServer;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\Config;

/**
 * Worker 命令行类
 */
class HttpWorker extends Command
{
    public function configure(): void
    {
        $this->setName('panda:http-worker')
            ->addArgument('action', Argument::OPTIONAL, 'start|stop|restart|reload|status|connections', 'start')
            ->addOption('daemonize', 'd', Option::VALUE_NONE, 'run the worker server in daemon mode.')
            ->addOption('module', 'm', Option::VALUE_OPTIONAL, 'the app of worker server.')
            ->setDescription('http-worker');
    }

    public function execute(Input $input, Output $output): int
    {
        $action = $input->getArgument('action');
        if (!\in_array($action, ['start', 'stop', 'reload', 'restart', 'status', 'connections'])) {
            $output->writeln(
                "<error>不支持此操作:{$action}" .
                ', Expected start|stop|restart|reload|status|connections .</error>'
            );
            return false;
        }

        if ($action === 'start') {
            $output->writeln('http-worker 正在运行.....');
        }

        // 设置worker全局配置参数
        $globalConfig = Config::get('__worker.global');
        $globalConfig['daemonize'] = $this->input->getOption('daemonize');
        HttpWorkerServer::setGlobalOptions($globalConfig);

        // 创建Http服务
        $moduleName = $this->input->getOption('module') ?: 'auto';
        $httpConfig = Config::get('__worker.http.' . $moduleName);

        // 实例化worker
        new HttpWorkerServer($this->app->getRootPath(), $moduleName, $httpConfig);

        // 启动monitor
        $monitorConfig = Config::get('__worker.monitor');
        if (!$this->isWin()) {
            if ($monitorConfig['status']) {
                new LinuxMonitor($this->app->getRootPath(), $monitorConfig);
            } else {
                $output->writeln('文件变动监听功能没有开启');
            }
        }

        HttpWorkerServer::runAll();

        return true;
    }

    private function isWin(): bool
    {
        return DIRECTORY_SEPARATOR === '\\';
    }
}
