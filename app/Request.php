<?php

namespace app;

class Request extends \think\Request
{
    protected $filter = [
        'strip_tags',
        'htmlspecialchars',
        'trim',
    ];
}
