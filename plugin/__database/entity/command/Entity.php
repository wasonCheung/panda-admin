<?php

namespace plugin\__database\entity\command;

use PDO;
use plugin\__database\entity\lib\GeneratorPdoFactory;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Config as ThinkConfig;

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
        $options = ThinkConfig::get('__database-entity');
        // 创建实体类
        $config = new \plugin\__database\entity\lib\Config();

        foreach ($options as $optionName => $optionsValue) {
            $config->{$optionName} = $optionsValue;
        }

        $database = ThinkConfig::get('database.connections.mysql.database');
        $username = ThinkConfig::get('database.connections.mysql.username');
        $password = ThinkConfig::get('database.connections.mysql.password');
        $hostname = ThinkConfig::get('database.connections.mysql.hostname');

        $pdo = new PDO("mysql:dbname=$database;host=$hostname", $username, $password);
        $generatorFactory = new GeneratorPdoFactory($pdo);
        $generator = $generatorFactory->create($config);
        $generator->generate();

        $output->writeln('实体类创建成功');
        return true;
    }
}
