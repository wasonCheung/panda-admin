<?php

namespace plugin\__worker\monitor;

class WinMonitor
{
    protected string $rootPath;
    protected array $config;
    protected string $run;

    public function __construct(string $rootPath, string $run, array $config)
    {
        $this->rootPath = $rootPath;
        $this->config = $config;
        $this->run = $run;
    }

    public function run(): void
    {
        $descriptors = [STDIN, STDOUT, STDOUT];
        $resource = proc_open($this->run, $descriptors, $pipes);
        while (true) {
            if (LinuxMonitor::checkFilesModify($this->config['dirs'], $this->rootPath, $this->config['types'])) {
                $pStatus = proc_get_status($resource);
                $pid = $pStatus['pid'];
                exec("taskkill /F /T /PID $pid");
                proc_close($resource);
                $resource = proc_open($this->run, $descriptors, $pipes);
            }
            sleep($this->config['interval']);
        }
    }
}
