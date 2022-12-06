<?php

namespace plugin\workerman\server;

use Workerman\Timer;
use Workerman\Worker;

/**
 * @Data: 2022/11/29
 * @Author: WasonCheung
 * @Description: 定时器
 */
abstract class TimerServer extends BaseServer
{
    protected int $timerId;
    protected array $config;
    protected string $rootPath;

    public function __construct(string $rootPath, array $config = [])
    {
        $this->config = $config;
        $this->rootPath = $rootPath;
        parent::__construct(new Worker(), $config['options']);
    }

    public function onWorkerStart(Worker $worker): void
    {
        $this->timerId = Timer::add($this->config['interval'], [$this, 'timerService']);
    }

    public function del(): bool
    {
        return Timer::del($this->timerId);
    }

    abstract protected function timerService(): void;
}
