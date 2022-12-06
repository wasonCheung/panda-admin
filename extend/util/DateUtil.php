<?php

namespace util;

class DateUtil
{
    /**
     * @param int|null $time 当前时间
     * @param string $format 格式化
     * @return string
     * 格式化日期
     */
    public static function date(int $time = null, string $format = 'Y-m-d H:i:s'): string
    {
        if ($time !== null) {
            return date($format, $time);
        }
        return date($format);
    }
}