<?php

namespace plugin\__plugin\provider;

use plugin\__plugin\Manager;
use plugin\__plugin\PluginBase;
use think\Lang as ThinkLang;

/**
 * @Data: 2022/11/22
 * @Author: WasonCheung
 * @Description: 注册插件多语言
 */
class Lang extends ThinkLang
{
    protected array $loaded = [];

    public function switchLangSet(string $langset): void
    {
        parent::switchLangSet($langset);
        if (!isset($this->loaded[$langset])) {
            // 确保每种语言只加载一次
            $this->loaded[$langset] = true;
            // 注册插件多语言包
            $this->pluginLangLoader(Manager::running()->list(), $langset);
        }
    }

    public function pluginLangLoader(array $plugins, string $langset): void
    {
        foreach ($plugins as $plugin) {
            /**
             * @var PluginBase $plugin
             */
            $langFiles = glob($plugin->getLangPath() . $langset . '.*');
            if ($langFiles) {
                $this->app->lang->load($langFiles);
                $this->app->isDebug() && $this->app->log->debug(
                    sprintf(
                        '[ %s ] [ %s ] %s %s语言包已加载',
                        $plugin->type,
                        $plugin->name,
                        $plugin->title,
                        $langset
                    )
                );
            }
        }
    }
}
