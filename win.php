<?php

require_once __DIR__ . '/vendor/autoload.php';
ini_set('display_errors', 'on');
error_reporting(E_ALL);

/**
 * 1、win下可以使用 taskkill /F /T /PID $pid 精确杀死进程，如果通过执行程序名则会出现误杀现象
 * 2、win下路由可能存在空格，所以可执行文件路径需要加入引号包裹，以防止被完整路径无法被cmd识别
 * 3、win下可以使用 start http://xxx.xxx.xxx.xx:xx/ 可直接唤起默认浏览器
 */


class M
{
    /**
     * @var array
     */
    protected $_paths = [];

    /**
     * @var array
     */
    protected $_extensions = [];

    public function __construct($monitor_dir, $monitor_extensions)
    {
        $this->_extensions = $monitor_extensions;
        $this->_paths      = $monitor_dir;
        exec('php -v ', $out, $var);
        $this->checkMode = ($var === 0);
    }

    public function checkAll()
    {
        foreach ($this->_paths as $path) {
            if ($this->check_files_change($path)) {
                return true;
            }
        }
        return false;
    }

    public function check_files_change($monitor_dir)
    {
        static $last_mtime;
        if (!$last_mtime) {
            $last_mtime = time();
        }
        clearstatcache();
        if (!is_dir($monitor_dir)) {
            if (!is_file($monitor_dir)) {
                return false;
            }
            $iterator = [new \SplFileInfo($monitor_dir)];
        } else {
            // recursive traversal directory
            $dir_iterator = new \RecursiveDirectoryIterator($monitor_dir);
            $iterator     = new \RecursiveIteratorIterator($dir_iterator);
        }
        foreach ($iterator as $file) {
            /** var SplFileInfo $file */
            if (is_dir($file)) {
                continue;
            }
            // check mtime
            if ($last_mtime < $file->getMTime() && in_array($file->getExtension(), $this->_extensions, true)) {
                $var = 0;
                if ($this->checkMode) {
                    $phpBin = PHP_BINARY;
                    exec('"' . $phpBin . '" -l ' . $file, $out, $var);
                } else {
                    exec(PHP_BINARY . " -l " . $file, $out, $var);
                }
                if ($var) {
                    $last_mtime = $file->getMTime();
                    continue;
                }
                echo $file . " update and reload\n";
                // send SIGUSR1 signal to master process for reload
                $last_mtime = $file->getMTime();
                return true;
            }
        }
        return false;
    }

}

$m = new M([
    __DIR__
], [
    'php', 'html', 'htm', 'env'
]);

$phpBin         = '"' . PHP_BINARY . '"';
$descriptorspec = [STDIN, STDOUT, STDOUT];

$run      = 'php think worker';
$resource = proc_open('php think worker', $descriptorspec, $pipes);

while (true) {
    $r = $m->checkAll();
    if ($r) {
        $pStatus = proc_get_status($resource);
        $PID     = $pStatus['pid'];
        kill($PID);
        proc_close($resource);
        $resource = proc_open('php think worker', $descriptorspec, $pipes);
    }
    sleep(1);
}

function kill($pid)
{
    return stripos(php_uname('s'), 'win') > -1 ? exec("taskkill /F /T /PID $pid") : exec("kill -9 $pid");
}