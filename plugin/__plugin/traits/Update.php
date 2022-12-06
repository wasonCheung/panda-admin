<?php

namespace plugin\__plugin\traits;

use plugin\__plugin\exception\PluginException;
use plugin\__plugin\Base;

trait Update
{
    /**
     * @return bool
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 更新
     */
    final public function update(): bool
    {
        if ($this->status !== Base::STATUS_WAIT4UPDATE) {
            throw new PluginException(sprintf('更新中止,插件状态必须为"待更新(%s)"', Base::STATUS_WAIT4UPDATE));
        }
        if ($this->__update()) {
            $this->status = Base::STATUS_DISABLE;
            return true;
        }
        throw new PluginException('未知原因导致更新失败,请检查!');
    }

    protected function __update(): bool
    {
        return true;
    }
}
