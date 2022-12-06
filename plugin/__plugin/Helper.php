<?php

namespace plugin\__plugin;

use Closure;
use think\Console;
use think\event\HttpRun;
use think\event\RouteLoaded;

class Helper
{
    /**
     * @Data: 2022/11/18
     * @Author: WasonCheung
     * @Description: 服务注册
     */
    public static function registrationServices(string|array|object $services): void
    {
        if (\is_object($services)) {
            app()->register($services);
            return;
        }

        if (\is_string($services) && is_file($services)) {
            $services = include $services;
        }
        foreach ($services as $service) {
            app()->register($service);
        }
    }

    /**
     * 添加指令
     * @access protected
     * @param array|string $commands 指令
     */
    public static function commands(...$commands): void
    {
        Console::starting(static function (Console $console) use ($commands) {
            $console->addCommands($commands);
        });
    }

    /**
     * @Data: 2022/11/21
     * @Author: WasonCheung
     * @Description: 引入文件
     */
    public static function includeFiles(...$files): void
    {
        foreach ($files as $file) {
            if (is_file($file)) {
                include $file;
            }
        }
    }

    /**
     * @param string|array $middleware
     * @Data: 2022/11/21
     * @Author: WasonCheung
     * @Description: 导入中间件
     */
    public static function importMiddlewares(string|array $middleware): void
    {
        if (\is_string($middleware) && is_file($middleware)) {
            $middleware = include $middleware;
        }
        if ($middleware) {
            app()->event->listen(HttpRun::class, function () use ($middleware) {
                app()->middleware->add($middleware);
            });
        }
    }

    /**
     * @Data: 2022/11/21
     * @Author: WasonCheung
     * @Description: 绑定容器
     */
    public static function bindProviders(string|array $providers): void
    {
        if (\is_string($providers) && is_file($providers)) {
            $providers = include $providers;
        }
        if ($providers) {
            app()->bind($providers);
        }
    }

    /**
     * @param string|array $events
     * @Data: 2022/11/21
     * @Author: WasonCheung
     * @Description: 加载时间
     */
    public static function loadEvents(string|array $events): void
    {
        if (\is_string($events) && is_file($events)) {
            $events = include $events;
        }
        if ($events) {
            app()->loadEvent($events);
        }
    }

    /**
     * @Data: 2022/11/18
     * @Author: WasonCheung
     * @Description: 加载路由目录
     */
    public static function registerRoutes(string|Closure $dir): void
    {
        if (\is_string($dir) && is_dir($dir)) {
            $files = glob($dir . '*.php');
            if ($files) {
                app()->event->listen(RouteLoaded::class, function () use ($files) {
                    foreach ($files as $file) {
                        include $file;
                    }
                });
            }
        } else {
            app()->event->listen(RouteLoaded::class, $dir);
        }
    }
}
