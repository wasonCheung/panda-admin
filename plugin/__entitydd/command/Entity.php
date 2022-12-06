<?php

namespace plugin\__entitydd\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * @Data: 2022/12/6
 * @Author: WasonCheung
 * @Description: 实体类生成
 */
class Entity extends Command
{
    public function configure(): void
    {
        $this->setName('panda:entity')
            ->setDescription('实体类生成');
    }

    protected function execute(Input $input, Output $output): bool
    {

    }
}