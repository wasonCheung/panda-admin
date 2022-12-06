<?php

namespace plugin\__plugin;

use plugin\__plugin\provider\Lang;
use think\App;

/**
 * @Data: 2022/12/5
 * @Author: WasonCheung
 * @Description: 插件启动
 */
class Starter
{
    protected App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function start(): void
    {
        // 插件多语言
        $this->app->bind('lang', Lang::class);
        // 配置加载
        $this->configLoad();
        // 插件启动
        $this->run();
    }

    /**
     * @Data: 2022/12/5
     * @Author: WasonCheung
     * @Description: 插件配置加载
     */
    private function configLoad(): void
    {
        foreach (Manager::running()->list() as $plugin) {
            /*** @var Base $plugin */
            $configPath = $plugin->getConfigPath();
            if (!is_dir($configPath)) {
                continue;
            }

            $configExt = $this->app->getConfigExt();
            $log = $this->app->log;

            foreach ((glob($configPath . '*' . $configExt)) as $file) {
                $this->app->config->load($file, pathinfo($file, PATHINFO_FILENAME));
            }

            // debug 打印
            APP_DEBUG && $log->debug(
                sprintf(
                    '[ %s ] [ %s ] %s 配置已加载',
                    $plugin->type,
                    $plugin->name,
                    $plugin->title
                )
            );
        }
    }

    /**
     * @Data: 2022/12/5
     * @Author: WasonCheung
     * @Description: 启动
     */
    private function run(): void
    {
        foreach (Manager::running()->list() as $plugin) {
            /**
             * @var Base $plugin
             */
            $plugin->run();

            APP_DEBUG && $this->app->log->debug(
                sprintf(
                    '[ %s ] [ %s ] %s 插件已启动',
                    $plugin->type,
                    $plugin->name,
                    $plugin->title
                )
            );
        }
    }
}