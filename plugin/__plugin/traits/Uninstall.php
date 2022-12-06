<?php

namespace plugin\__plugin\traits;

use plugin\__plugin\exception\PluginException;
use plugin\__plugin\PluginBase;

trait Uninstall
{
    /**
     * @return bool
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 卸载
     */
    final public function uninstall(): bool
    {
        if ($this->status !== PluginBase::STATUS_DISABLE) {
            throw new PluginException(sprintf('卸载中止,插件状态必须为"停用(%s)"', PluginBase::STATUS_DISABLE));
        }
        if ($this->__uninstall()) {
            $this->status = PluginBase::STATUS_WAIT4INSTALL;
            return true;
        }
        throw new PluginException('未知原因导致卸载失败,请检查!');
    }

    protected function __uninstall(): bool
    {
        return true;
    }
}
