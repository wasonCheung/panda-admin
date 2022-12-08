<?php

namespace app\index\controller;

use plugin\__plugin\provider\Running;
use think\Cookie;
use think\Request;
use think\Session;

class Index
{
    public function index(Request $request, Cookie $cookie, Session $session,Running $running)
    {

        return 'dd';
    }
}
