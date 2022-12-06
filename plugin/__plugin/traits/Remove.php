<?php

namespace plugin\__plugin\traits;

use plugin\__plugin\exception\PluginException;
use plugin\__plugin\Base;
use util\FileUtil;

trait Remove
{
    /**
     * @return bool
     * @Data: 2022/12/3
     * @Author: WasonCheung
     * @Description: 删除
     */
    final public function remove(): bool
    {
        if ($this->status !== Base::STATUS_WAIT4INSTALL) {
            throw new PluginException(sprintf('删除中止,插件状态必须为"待安装(%s)"', Base::STATUS_WAIT4INSTALL));
        }
        if ($this->__remove()) {
            return true;
        }
        throw new PluginException('未知原因导致删除失败,请检查!');
    }

    protected function __remove(): bool
    {
        return FileUtil::deldir($this->getRootPath());
    }
}
