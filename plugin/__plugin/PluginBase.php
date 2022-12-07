<?php

namespace plugin\__plugin;

use plugin\__plugin\exception\PluginException;
use think\App;

/**
 * @Data: 2022/11/20
 * @Author: WasonCheung
 * @Description: 插件基类
 *
 * @property $title 获取插件标题
 * @property $intro 获取插件简介
 * @property $author 获取插件作者
 * @property $website 获取插件网站
 * @property $version 获取插件版本
 * @property $status 插件状态
 * @property $priority 优先级
 * @property $mode 模式类型
 * @property $type 插件类型
 * @property $debug debug类型
 *
 * @method bool enable() 启用
 * @method bool disable() 停用
 * @method bool install() 安装
 * @method bool uninstall() 卸载
 * @method bool update() 更新
 * @method bool remove() 移除
 */
abstract class PluginBase
{
    // 命令行
    public const MODE_CLI = 'cli';
    // nginx
    public const MODE_CGI = 'cgi';
    // 全部
    public const MODE_BOTH = 'both';
    // debug模式下
    public const DEBUG_ONLY = 'only';
    // 非debug
    public const DEBUG_NOT = 'not';
    // 全部
    public const DEBUG_BOTH = 'both';
    // 停用
    public const STATUS_DISABLE = 'disable';
    // 开启
    public const STATUS_ENABLE = 'enable';
    // 等待安装
    public const STATUS_WAIT4INSTALL = 'wait4install';
    // 等待更新
    public const STATUS_WAIT4UPDATE = 'wait4update';

    /**
     * @var string 插件名
     */
    public string $name;
    /**
     * @var App $app
     */
    protected App $app;
    /**
     * @var string 插件根目录
     */
    protected string $rootPath;
    /**
     * @var array 插件配置
     */
    protected array $info = [];

    /**
     * @param App $app
     * @param string $name
     * @param string $rootPath
     * @param array $info
     */
    public function __construct(App $app, string $name, string $rootPath, array $info)
    {
        $this->app = $app;
        $this->rootPath = $rootPath;
        $this->info = $this->infoInit($info, $name);
        $this->name = $name;
    }

    /**
     * @param array $info
     * @param string $name
     * @return array
     * @Data: 2022/12/5
     * @Author: WasonCheung
     * @Description: 插件信息初始化
     */
    private function infoInit(array $info, string $name): array
    {
        // info.php 字段
        $fields = [
            'title',
            'intro',
            'author',
            'website',
            'version',
            'status',
            'mode',
            'type',
            'priority',
            'debug'
        ];
        // 检查字段是否完整
        foreach ($fields as $field) {
            if (!\array_key_exists($field, $info)) {
                throw new PluginException(sprintf('[ %s ]插件缺少配置 "%s",请补充！', $name, $field));
            }
        }
        return $info;
    }

    /**
     * @return string
     * @Data: 2022/12/5
     * @Author: WasonCheung
     * @Description: 插件运行目录
     */
    public function getRuntimePath(): string
    {
        return $this->app->getRuntimePath() . $this->name . DIRECTORY_SEPARATOR;
    }

    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    public function run(): void
    {
        if ($this->app->runningInConsole()) {
            $this->runningInConsole();
        } else {
            $this->runningInCliServer();
        }
    }

    protected function runningInConsole(): void
    {
    }

    protected function runningInCliServer(): void
    {
    }

    public function getConfigPath(): string
    {
        return $this->rootPath . 'config' . DIRECTORY_SEPARATOR;
    }

    public function getLangPath(): string
    {
        return $this->rootPath . 'lang' . DIRECTORY_SEPARATOR;
    }

    public function __get(string $name)
    {
        return $this->info[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->info[$name] = $value;
        file_put_contents(
            $this->getMetaPath() . 'info.php',
            "<?php\n\nreturn " . var_export($this->getInfo(), true) . ";\n"
        );
    }

    public function getMetaPath(): string
    {
        return $this->rootPath . 'meta' . DIRECTORY_SEPARATOR;
    }

    public function getInfo(): array
    {
        return $this->info;
    }

    public function __call(string $method, array $arguments)
    {
        if (method_exists($this, $method)) {
            return \call_user_func_array([$this, $method], $arguments);
        }
        throw new PluginException(sprintf('[ %s ]插件不支持此操作 %s', $this->name, $method));
    }
}
