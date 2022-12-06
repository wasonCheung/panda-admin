<?php

namespace plugin\__plugin\traits;

use plugin\__plugin\exception\PluginException;
use plugin\__plugin\Base;

trait Disable
{
    /**
     * @return bool
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 停用
     */
    final public function disable(): bool
    {
        if ($this->status !== Base::STATUS_ENABLE) {
            throw new PluginException(sprintf('停用中止,插件状态必须为"启用(%s)"', Base::STATUS_ENABLE));
        }
        if ($this->__disable()) {
            $this->status = Base::STATUS_DISABLE;
            return true;
        }
        throw new PluginException('未知原因导致停用失败,请检查!');
    }

    protected function __disable(): bool
    {
        return true;
    }
}