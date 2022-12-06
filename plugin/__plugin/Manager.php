<?php

namespace plugin\__plugin;

use plugin\__plugin\provider\Running;
use think\Container;

/**
 * @Data: 2022/12/3
 * @Author: WasonCheung
 * @Description: 插件配置发布
 */
class Manager
{
    /**
     * @param string $status 插件状态
     * @param string $pluginPath 插件地址
     * @param string $namespace 插件命名空间
     * @param bool $runningInConsole 是否在命令行下运行
     * @param bool $debug debug类型
     * @return array
     * @Data: 2022/11/28
     * @Author: WasonCheung
     * @Description: 插件查找
     */
    public static function findWith(
        string $status,
        string $pluginPath,
        string $namespace,
        bool $runningInConsole,
        bool $debug
    ): array {
        $res = [];
        // 当前运行环境
        $mode = $runningInConsole ? PluginBase::MODE_CLI : PluginBase::MODE_CGI;
        $debug = $debug ? PluginBase::DEBUG_ONLY : PluginBase::DEBUG_NOT;
        foreach (self::scanAllPlugins($pluginPath, $namespace) as $plugin) {
            if ($plugin['info']['status'] !== $status) {
                continue;
            }

            if ($plugin['info']['debug'] !== PluginBase::DEBUG_BOTH && $plugin['info']['debug'] !== $debug) {
                continue;
            }

            if ($plugin['info']['mode'] !== PluginBase::MODE_BOTH && $plugin['info']['mode'] !== $mode) {
                continue;
            }

            $res[$plugin['class']] = $plugin;
        }

        return $res;
    }

    /**
     * @param string $pluginPath
     * @param string $namespace
     * @return array
     * @Data: 2022/11/28
     * @Author: WasonCheung
     * @Description: 插件发现
     */
    public static function scanAllPlugins(string $pluginPath, string $namespace): array
    {
        $dirList = scandir($pluginPath);
        $all = [];
        // 遍历所有目录
        foreach ($dirList as $dirName) {
            if ($dirName === '.' || $dirName === '..') {
                continue;
            }

            $plugin = self::getWith(
                $pluginPath,
                $namespace,
                $dirName
            );

            if ($plugin) {
                $all[] = $plugin;
            }
        }
        return $all;
    }

    /**
     * @param string $pluginPath
     * @param string $namespace
     * @param string $name
     * @param bool $makeInstance
     * @return array|PluginBase
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 根据名字获取插件对象
     */
    public static function getWith(
        string $pluginPath,
        string $namespace,
        string $name,
        bool $makeInstance = false
    ): array|PluginBase {
        $path = $pluginPath . $name . DIRECTORY_SEPARATOR;
        // 插件信息文件
        $info = $path . 'meta' . DIRECTORY_SEPARATOR . 'info.php';
        // 不是插件
        if (!is_file($info)) {
            return [];
        }

        // 是否存在类
        $class = $name . '\\Plugin';
        $class = $namespace ? $namespace . '\\' . $class : $class;
        if (!class_exists($class)) {
            return [];
        }

        if ($makeInstance) {
            return self::makeInstance($class, [
                'name' => $name,
                'rootPath' => $path,
                'info' => include $info
            ]);
        }

        return [
            'class' => $class,
            'name' => $name,
            'rootPath' => $path,
            'info' => include $info
        ];
    }

    /**
     * @param string $class
     * @param array $vars
     * @return PluginBase
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 创建实例
     */
    public static function makeInstance(string $class, array $vars = []): PluginBase
    {
        return app($class, $vars);
    }

    /**
     * @param array $plugins
     * @return void
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 优先级排序
     */
    public static function prioritySort(array &$plugins): void
    {
        // 插件优先级排序
        usort($plugins, static function ($a, $b) {
            $aPriority = $a->priority;
            $bPriority = $b->priority;
            if ($aPriority === $bPriority) {
                return 0;
            }
            return $aPriority < $bPriority ? -1 : 1;
        });
    }

    /**
     * @param array $plugins
     * @param mixed ...$types
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 插件过滤
     */
    public static function typeFilter(array &$plugins, ...$types): void
    {
        foreach ($types as $type) {
            unset($plugins[$type]);
        }
    }

    /**
     * @return Running
     * @Data: 2022/12/5
     * @Author: WasonCheung
     * @Description: 获取正在运行的插件列表
     */
    public static function running(): Running
    {
        return Container::getInstance()->make(Running::class);
    }
}
