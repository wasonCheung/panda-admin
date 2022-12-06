<?php

namespace generator;

use generator\entity\Config;
use generator\entity\GeneratorPdoFactory;
use PDO;
use PHPUnit\Framework\TestCase;
use think\App;
use think\facade\Config as ThinkConfig;

class PandaEntityGenerator extends TestCase
{
    /**
     * @Data: 2022/11/23
     * @Author: WasonCheung
     * @Description: 生产Panda数据库实体类，方便调试
     */
    public function test(): void
    {
        (new App())->http->run();

        $config = new Config();

        $config->typeMapping = [
            'int' => ['int', 'bigint', 'mediumint', 'smallint', 'tinyint'],
            'float' => ['decimal', 'float'],
            'bool' => ['bit'],
        ];

        $config->primaryKeyConstant = 'PRIMARY_KEY';

        $config->strictlyTypedProperties = true;
        $config->generateProperties = false;

        $config->extends = null;

        $config->rewrite = true;

        $config->addDeclareStrictTypes = true;

        $config->addPropertyVarComment = false;

        $config->generatePhpDocProperties = true;


        $config->toAarray = true;

        $config->suffix = 'Entity';

        $config->generatePropertiesByArray = true;

        $config->replacements = [
            'panda' => '',
        ];

        $config->setterBody = '$this->fields[\'__FIELD__\'] = $value;' . "\n" . 'return $this;';

        $config->getterBody = 'return $this->fields[\'__FIELD__\'];';

        $config->path = \dirname(__DIR__) . '/../database/entity';

        $config->namespace = 'database\\entity';

        $database = ThinkConfig::get('database.connections.mysql.database');
        $username = ThinkConfig::get('database.connections.mysql.username');
        $password = ThinkConfig::get('database.connections.mysql.password');
        $hostname = ThinkConfig::get('database.connections.mysql.hostname');

        $pdo = new PDO("mysql:dbname=$database;host=$hostname", $username, $password);
        $generatorFactory = new GeneratorPdoFactory($pdo);
        $generator = $generatorFactory->create($config);
        $generator->generate();
    }
}
