<?php


namespace plugin\workerman\command;

use plugin\workerman\server\HttpServer;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\Config;

/**
 * Worker 命令行类
 */
class Worker extends Command
{
    public function configure(): void
    {
        $this->setName('worker')
            ->addArgument('action', Argument::OPTIONAL, 'start|stop|restart|reload|status|connections', 'start')
            ->addOption('daemonize', 'd', Option::VALUE_NONE, 'run the worker server in daemon mode.')
            ->addOption('module', 'm', Option::VALUE_OPTIONAL, 'the app of worker server.')
            ->setDescription('HTTP Worker Server for ThinkPHP');
    }

    public function execute(Input $input, Output $output): int
    {
        $action = $input->getArgument('action');

        if (DIRECTORY_SEPARATOR !== '\\') {
            if (!\in_array($action, ['start', 'stop', 'reload', 'restart', 'status', 'connections'])) {
                $output->writeln(
                    "<error>Invalid argument action:{$action}" .
                    ', Expected start|stop|restart|reload|status|connections .</error>'
                );
                return false;
            }
            global $argv;
            array_shift($argv);
            array_shift($argv);
            array_unshift($argv, 'think', $action);
        } elseif ($action !== 'start') {
            $output->writeln("<error>Not Support action:{$action} on Windows.</error>");
            return false;
        }

        if ($action === 'start') {
            $output->writeln('Starting Workerman http server...');
        }

        // 设置worker全局配置参数
        $globalConfig = Config::get('p-worker');
        $globalConfig['daemonize'] = $this->input->getOption('daemonize');
        HttpServer::setGlobalOptions($globalConfig);

        // 创建Http服务
        $moduleName = $this->input->getOption('module') ?: 'auto';
        $httpConfig = Config::get('p-worker-http.' . $moduleName);

        // 实例化worker
        new HttpServer($this->app->getRootPath(), $moduleName, $httpConfig);

        if ($this->isWin()) {
            $output->writeln('You can exit with <info>`CTRL-C`</info>');
        }

        HttpServer::runAll();

        return true;
    }

    private function isWin(): string
    {
        return DIRECTORY_SEPARATOR === '\\';
    }
}
