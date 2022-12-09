<?php

declare(strict_types=1);

namespace plugin\__common\model;

use think\Model;
use util\DateUtil;

class Admin extends Model
{
    public function getLastLoginTimeAttr($value): string
    {
        return DateUtil::date($value);
    }
}
