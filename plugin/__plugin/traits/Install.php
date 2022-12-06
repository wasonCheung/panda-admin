<?php

namespace plugin\__plugin\traits;

use plugin\__plugin\exception\PluginException;
use plugin\__plugin\Base;

trait Install
{


    /**
     * @return bool
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 安装
     */
    final public function install(): bool
    {
        if ($this->status !== Base::STATUS_WAIT4INSTALL) {
            throw new PluginException(sprintf('安装中止,插件状态必须为"待安装(%s)"', Base::STATUS_WAIT4INSTALL));
        }
        if ($this->__install()) {
            $this->status = Base::STATUS_DISABLE;
            return true;
        }
        throw new PluginException('未知原因导致安装失败,请检查!');
    }

    protected function __install(): bool
    {
        return true;
    }

}