<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace plugin\workerman\command;

use plugin\Worker\Servers\HttpServer;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Config;

/**
 * Worker 命令行类
 */
class WorkerMonitor extends Command
{
    public function configure(): void
    {
        $this->setName('worker:monitor')
            ->setDescription('worker 文件变动监听已启动');
    }

    public function execute(Input $input, Output $output): int
    {
        $monitorConfig = Config::get('p-worker-monitor');

        if (!$monitorConfig['status']) {
            $output->writeln('<error>p-worker-monitor is not enabled</error>');
            return false;
        }


        // 设置worker全局配置参数
        $globalConfig = Config::get('p-worker');
        $globalConfig['daemonize'] = $this->input->getOption('daemonize');
        HttpServer::setGlobalOptions($globalConfig);


        HttpServer::runAll();

        return true;
    }

    private function isWin(): string
    {
        return DIRECTORY_SEPARATOR === '\\';
    }
}
