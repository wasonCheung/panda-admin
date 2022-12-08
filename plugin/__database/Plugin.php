<?php

namespace plugin\__database;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use plugin\__database\think\command\factory\Create as FactoryCreate;
use plugin\__database\think\command\migrate\Breakpoint as MigrateBreakpoint;
use plugin\__database\think\command\migrate\Create as MigrateCreate;
use plugin\__database\think\command\migrate\Rollback as MigrateRollback;
use plugin\__database\think\command\migrate\Run as MigrateRun;
use plugin\__database\think\command\migrate\Status as MigrateStatus;
use plugin\__database\think\command\seed\Create as SeedCreate;
use plugin\__database\think\command\seed\Run as SeedRun;
use plugin\__database\think\Factory;
use plugin\__plugin\Helper;
use plugin\__plugin\PluginBase;

/**
 * @Data: 2022/11/21
 * @Author: WasonCheung
 * @Description: 数据库管理插件
 */
class Plugin extends PluginBase
{
    protected function runningInConsole(): void
    {
        $this->app->bind(FakerGenerator::class, function () {
            return FakerFactory::create($this->app->config->get('app.faker_locale', 'zh_CN'));
        });

        $this->app->bind(Factory::class, function () {
            return (new Factory($this->app->make(FakerGenerator::class)))->load(
                __DIR__ . '/database/factories/'
            );
        });

        $this->app->bind('migration.creator', \plugin\__database\think\Creator::class);

        Helper::commands(
            MigrateCreate::class,
            MigrateRun::class,
            MigrateRollback::class,
            MigrateBreakpoint::class,
            MigrateStatus::class,
            SeedCreate::class,
            SeedRun::class,
            FactoryCreate::class,
        );
    }
}
