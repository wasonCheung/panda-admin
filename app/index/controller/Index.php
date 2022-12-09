<?php

namespace app\index\controller;

use plugin\__kernel\abstracts\SimpleRABC;
use plugin\__plugin\provider\Running;
use think\Cookie;
use think\facade\Console;
use think\Request;
use think\Session;

class Index
{
    public function index(Request $request, Cookie $cookie, Session $session, Running $running)
    {
        # strings convert to

        return SimpleRABC::class;
    }

}
