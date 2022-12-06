<?php

namespace plugin\__plugin\provider;

use plugin\__plugin\Manager;
use plugin\__plugin\Base;
use think\App;

/**
 * @Data: 2022/11/28
 * @Author: WasonCheung
 * @Description: 运行的插件
 */
class Running
{
    // 所在目录
    protected string $pluginPath;
    // 命名空间
    protected string $namespace;

    /**
     * @var array|null 当前运行的插件列表
     */
    protected ?array $runLists = null;

    protected App $app;

    public function __construct(string $pluginPath, string $namespace, App $app)
    {
        $this->pluginPath = $pluginPath;
        $this->namespace = $namespace;
        $this->app = $app;
    }

    public static function __make(App $app): self
    {
        $config = $app->config->get('panda');
        return new self($config['plugin_path'], $config['plugin_namespace'], $app);
    }

    /**
     * @return array
     * @Data: 2022/11/28
     * @Author: WasonCheung
     * @Description: 获取当前运行的插件
     */
    public function list(): array
    {
        if ($this->runLists !== null) {
            return $this->runLists;
        }

        // 所有启动的插件
        $enables = Manager::findWith(
            Base::STATUS_ENABLE,
            $this->pluginPath,
            $this->namespace,
            $this->app->runningInConsole(),
            $this->app->isDebug()
        );

        if ($enables) {
            // 实例化所有插件
            foreach ($enables as $class => $item) {
                $this->runLists[] = Manager::makeInstance($class, $item);
            }
            // 插件优先级排序
            Manager::prioritySort($this->runLists);
            return $this->runLists;
        }
        return $this->runLists = [];
    }
}
