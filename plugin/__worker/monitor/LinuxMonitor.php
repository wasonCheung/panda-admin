<?php

namespace plugin\__worker\monitor;

use plugin\__worker\worker\TimerWorker;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * @Data: 2022/12/6
 * @Author: WasonCheung
 * @Description: 文件修改监控
 */
class LinuxMonitor extends TimerWorker
{
    public function timerService(): void
    {
        if (self::checkFilesModify($this->config['dirs'], $this->rootPath, $this->config['types'])) {
            \posix_kill(\posix_getppid(), SIGUSR1);
        }
    }

    /**
     * @param array $dirs
     * @param string $rootPath
     * @param array $types
     * @return bool
     * @Data: 2022/12/7
     * @Author: WasonCheung
     * @Description: 检查文件修改
     */
    public static function checkFilesModify(array $dirs, string $rootPath, array $types): bool
    {
        clearstatcache();
        static $last_mtime;
        if (!$last_mtime) {
            $last_mtime = time();
        }
        foreach ($dirs as $dir) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath . $dir . DIRECTORY_SEPARATOR)
            );
            foreach ($files as $file) {
                if (is_dir($file)) {
                    continue;
                }

                if ($last_mtime >= $file->getMTime()) {
                    continue;
                }

                if (!\in_array(pathinfo($file, PATHINFO_EXTENSION), $types, true)) {
                    continue;
                }

                echo '[update]' . $file . "\n";
                $last_mtime = $file->getMTime();
                return true;
            }
        }
        return false;
    }
}
