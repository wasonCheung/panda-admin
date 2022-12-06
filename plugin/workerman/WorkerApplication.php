<?php

namespace plugin\workerman;

use think\App;

/**
 * @Data: 2022/11/29
 * @Author: WasonCheung
 * @Description worker application
 */
class WorkerApplication extends App
{
    /**
     * @Data: 2022/11/29
     * @Author: WasonCheung
     * @Description: 重置应用信息
     */
    public function workerApplicationInit(): void
    {
        // 初始统计信息
        $this->beginTime = microtime(true);

        $this->beginMem = memory_get_usage();

        $this->db->clearQueryTimes();
    }

    /**
     * @return bool
     * @Data: 2022/11/29
     * @Author: WasonCheung
     * @Description: 设置非命令行模式
     */
    public function runningInConsole(): bool
    {
        return false;
    }
}
