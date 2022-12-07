<?php

namespace app\index\controller;

use think\Cookie;
use think\Request;
use think\Session;

class Index
{
    public function index(Request $request, Cookie $cookie, Session $session)
    {
        return $session->getId();
    }
}
