<?php

namespace app\index\controller;

use __test\Test;
use plugin\PandaPlugin\Plugin;
use plugin\PandaPlugin\Types\PluginSystem;
use think\Cookie;
use think\Request;
use think\Session;

class Index
{
    public function index(Request $request, Cookie $cookie, Session $session)
    {
       dump(Test::class);
        return $session->getId();
    }
}
