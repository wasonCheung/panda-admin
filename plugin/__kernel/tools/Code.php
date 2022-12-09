<?php

namespace plugin\__kernel\tools;

/**
 * @Data: 2022/12/9
 * @Author: WasonCheung
 * @Description: 根据字符串获取响应编码
 */
class Code
{
    public static array $mapping = [];

    public static function make(string $string): int
    {
        if (isset(self::$mapping[$string])) {
            return self::$mapping[$string];
        }
        $code = 0;
        foreach (str_split((\strlen($string) > 32 ? md5($string) : $string)) as $char) {
            $code += \ord($char);
        }
        $code %= 100000;
        return self::$mapping[$string] = $code;
    }
}
