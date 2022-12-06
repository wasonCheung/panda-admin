<?php

use database\entity\AdminEntity;
use think\migration\Seeder;

class Admin extends Seeder
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
        $data = [];
        for ($i = 0; $i < 5; $i++) {
            $obj = new AdminEntity();
            $obj->setStatus(1)
                ->setUsername($faker->userName)
                ->setPassword($faker->password)
                ->setNickname($faker->userName)
                ->setAvatar($faker->uuid)
                ->setEmail($faker->email)
                ->setLastLoginTime($faker->unixTime);

            $data[] = $obj->toArray(true);
        }


        $this->table('admin')->insert($data)->save();
    }
}