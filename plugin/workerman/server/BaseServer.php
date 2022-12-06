<?php

namespace plugin\workerman\server;

use Workerman\Connection\TcpConnection;
use Workerman\Worker;

use function plugin\__workerman\server\str_starts_with;


/**
 * @Data: 2022/11/26
 * @Author: WasonCheung
 * @Description:服务类
 */
abstract class BaseServer
{
    protected Worker $worker;
    protected bool $debug = true;

    public function __construct(Worker $worker, array $options = [])
    {
        $this->worker = $worker;
        // 绑定回调
        foreach (get_class_methods($this) as $method) {
            if (str_starts_with($method, 'on')) {
                $this->worker->{$method} = [$this, $method];
            }
        }
        // 绑定参数
        foreach ($options as $key => $value) {
            $this->worker->{$key} = $value;
        }
    }

    public static function setGlobalOptions(array $globalOptions = []): void
    {
        // 设置worker全局配置参数
        foreach ($globalOptions as $name => $value) {
            Worker::${$name} = $value;
        }
    }

    public static function runAll(): void
    {
        Worker::runAll();
    }

    public static function stopAll(): void
    {
        Worker::stopAll();
    }

    public function onWorkerStart(Worker $worker): void
    {
        if ($this->debug) {
            echo "[onWorkerStart] Worker {$worker->workerId} starting..." . PHP_EOL;
        }
    }

    public function onWorkerReload(Worker $worker): void
    {
        if ($this->debug) {
            foreach ($worker->connections as $connection) {
                $connection->send('[onWorkerReload] worker reloading');
            }
        }
    }

    public function onConnect(TcpConnection $connection): void
    {
        if ($this->debug) {
            echo "[onConnect] new connection from ip {$connection->getRemoteIp()}" . PHP_EOL;
        }
    }

    public function onMessage(TcpConnection $connection, mixed $data): void
    {
        if ($this->debug) {
            $connection->send('[onMessage] receive success');
        }
    }

    public function onClose(TcpConnection $connection): void
    {
        if ($this->debug) {
            echo '[onClose] connection closed' . PHP_EOL;
        }
    }

    public function onBufferFull(TcpConnection $connection): void
    {
        if ($this->debug) {
            echo '[onBufferFull] bufferFull and do not send again' . PHP_EOL;
        }
    }

    public function onBufferDrain(TcpConnection $connection): void
    {
        if ($this->debug) {
            echo '[onBufferDrain] buffer drain and continue send' . PHP_EOL;
        }
    }

    public function onError(TcpConnection $connection, int $code, string $msg): void
    {
        if ($this->debug) {
            echo "[onError] error $code $msg" . PHP_EOL;
        }
    }
}
