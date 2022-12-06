<?php

namespace util;

class IpUtil
{
    /**
     * @param string $ip
     * @return int|string
     * 将ip地址转换成long
     */
    public static function ip2long(string $ip): int|string
    {
        $ip_long = sprintf('%u', ip2long($ip));
        // 排除不正确的IP
        if ($ip_long < 0 || $ip_long >= 0xFFFFFFFF) {
            $ip_long = 0;
        }
        return $ip_long;
    }

    /**
     * @param int $long
     * @param bool $hidden 是否隐藏
     * @return string
     * 将long转换成ip
     */
    public static function long2ip(int $long, bool $hidden = false): string
    {
        $ip = long2ip($long);
        if ($hidden) {
            return preg_replace('~(\d+)\.(\d+)\.(\d+)\.(\d+)~', '$1.$2.*.*', $ip);
        }
        return $ip;
    }
}
