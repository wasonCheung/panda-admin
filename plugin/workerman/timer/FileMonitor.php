<?php

namespace plugin\workerman\timer;

use plugin\workerman\server\TimerServer;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileMonitor extends TimerServer
{
    private int $lastMtime;
    public function __construct(string $rootPath, array $config = [])
    {
        $this->lastMtime = time();
        parent::__construct($rootPath, $config);
    }

    protected function timerService(): void
    {
        clearstatcache();
        foreach ($this->config['dirs'] as $dir) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->rootPath . $dir));
            foreach ($files as $file) {
                if (!\in_array(pathinfo($file, PATHINFO_EXTENSION), $this->config['types'], true)) {
                    continue;
                }
                if ($this->lastMtime < $file->getMTime()) {
                    echo '[update]' . $file . "\n";
                    posix_kill(posix_getppid(), SIGUSR1);
                    $this->lastMtime = $file->getMTime();
                    return;
                }
            }
        }
    }
}
