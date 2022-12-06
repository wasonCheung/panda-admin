<?php

namespace plugin\__plugin\traits;

use plugin\__plugin\exception\PluginException;
use plugin\__plugin\PluginBase;

trait Enable
{
    /**
     * @return bool
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 启用
     */
    final  public function enable(): bool
    {
        if ($this->status !== PluginBase::STATUS_DISABLE) {
            throw new PluginException(sprintf('启用中止,插件状态必须为"停用(%s)"', PluginBase::STATUS_DISABLE));
        }
        if ($this->__enable()) {
            $this->status = PluginBase::STATUS_ENABLE;
            return true;
        }
        throw new PluginException('未知原因导致启用失败,请检查!');
    }

    protected function __enable(): bool
    {
        return true;
    }
}
