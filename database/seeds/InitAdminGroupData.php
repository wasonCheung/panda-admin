<?php

use app\entity\AdminGroupEntity;
use think\migration\Seeder;

class InitAdminGroupData extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create('zh_CN');//选择中文库
        try {
            $data = [];
            $obj = new AdminGroupEntity();
            $obj
                ->setId(1)
                ->setStatus(1)
                ->setName('超级管理员')
                ->setCreateTime(time())
                ->setUpdateTime(time())
                ->setRules('*');
            $data[] = $obj->toArray(true);
            $this->table('admin_group')->setData($data)->update();
        } catch (Throwable $throwable) {
        }
    }
}
