<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
namespace plugin\__database\think;

use plugin\__database\phinx\seed\AbstractSeed;

class Seeder extends AbstractSeed
{
    /**
     * @return Factory
     */
    public function factory()
    {
        return app(Factory::class);
    }
}