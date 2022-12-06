<?php

namespace util;

use Exception;
use JsonException;

class StringUtil
{
    /**
     * @param string $str
     * @param array $var
     * @return string
     * 字符串占位符{}变量解析 类似java的log
     * @throws JsonException
     */
    public static function varParse(string $str, array $var): string
    {
        if ($var && str_contains($str, '{}')) {
            foreach ($var as $item) {
                if (\is_string($item)) {
                    $str = preg_replace('/{}/', $item, $str, 1);
                } else {
                    $str = preg_replace('/{}/', json_encode($item, JSON_THROW_ON_ERROR), $str, 1);
                }
            }
        }
        return $str;
    }

    /**
     * @param string $haystack 被检查的字符串
     * @param array|string $needles 查询字符串
     * @return bool
     * 检查字符串中是否包含某些字符串
     */
    public static function contains(string $haystack, array|string $needles): bool
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && str_contains($haystack, $needle)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $haystack 被检查的字符串
     * @param array|string $needles 查询字符串
     * @return bool
     * 检查字符串是否以某些字符串结尾
     */
    public static function endWiths(string $haystack, array|string $needles): bool
    {
        foreach ((array)$needles as $needle) {
            if ((string)$needle === self::substr($haystack, -self::length($needle))) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $haystack 被检查的字符串
     * @param array|string $needles 查询字符串
     * @return bool
     * 检查字符串是否以某些字符串开头
     */
    public static function startWiths(string $haystack, array|string $needles): bool
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && str_starts_with($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $string
     * @return int
     * 获取字符串的长度
     */
    public static function length(string $string): int
    {
        return mb_strlen($string, 'UTF-8');
    }

    /**
     * @param string $string 截取的字符串
     * @param int $start 起始位置
     * @param int|null $length 长度
     * @return string
     * 字符串截取
     */
    public static function substr(string $string, int $start, int $length = null): string
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * @param string $value
     * @param string $delimiter
     * @return string
     * 驼峰转下划线
     */
    public static function convert2snake(string $value, string $delimiter = '_'): string
    {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = self::convert2lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }
        return $value;
    }

    /**
     * @param string $originalString
     * @return array
     * 将中文字符串转换成数组的形式
     */
    public static function convert2array(string $originalString): array
    {
        $str_array = preg_split('/(?<!^)(?!$)/u', $originalString);
        $newArr = [];
        $word = '';
        foreach ($str_array as $iValue) {
            if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $iValue)) {
                if ($word) {
                    $newArr[] = $word;
                    $word = '';
                }
                $newArr[] = $iValue;
            } else {
                $word .= $iValue;
            }
        }
        if ($word) {
            $newArr[] = $word;
        }
        return $newArr;
    }

    /**
     * @param string $string
     * @return string
     * 下划线转驼峰(首字母小写)
     */
    public static function convert2camel(string $string): string
    {
        return lcfirst(self::convert2studly($string));
    }

    /**
     * @param string $string
     * @return string
     * 下划线转驼峰(首字母大写)
     */
    public static function convert2studly(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
    }

    /**
     * @param string $string
     * @return string
     * 转为首字母大写的标题格式
     */
    public static function convert2title(string $string): string
    {
        return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * @param string $string
     * @return string
     * 字符串转小写
     */
    public static function convert2lower(string $string): string
    {
        return mb_strtolower($string, 'UTF-8');
    }

    /**
     * @param string $string
     * @return string
     * 字符串转大写
     */
    public static function convert2upper(string $string): string
    {
        return mb_strtoupper($string, 'UTF-8');
    }

    /**
     * @param $original
     * @return string
     * 将字符串转换成unicoe模式
     */
    public static function convert2unicode($original): string
    {
        return mb_convert_encoding($original, 'HTML-ENTITIES');
    }


    /**
     * @param string $value
     * @return string
     * 长字符缩短
     */
    public static function make2shorten(string $value): string
    {
        $result = static function ($x): string {
            $show = '';
            while ($x-- > 0) {
                $s = $x % 62;
                if ($s > 35) {
                    $s = \chr($s + 61);
                } elseif ($s > 9) {
                    $s = \chr($s + 55);
                }
                $show .= $s;
                $x = floor($x / 62);
            }
            return $show;
        };
        return $result(sprintf('%u', crc32($value)));
    }

    /**
     * @param string $string
     * @param string $spec
     * @return string
     * @throws Exception
     * 字符串混肴 插入特殊字符等操作
     */
    public static function make2mixed(string $string, string $spec = ''): string
    {
        $length =  self::length($string, 'UTF-8');
        $start = 0;
        $newStr = '';
        while ($start < $length) {
            $number = random_int(40, 80);
            $spe = str_repeat($spec, random_int(4, 8));
            $newStr .= self::substr($string, $start, $number) . $spe;
            $start += $number;
        }
        return $newStr;
    }

    /**
     * @param string $originalString
     * @param string $cnSeparator 中文字符
     * @param string $otherSeparator 其它字符
     * @return string
     * 自定义文字分割
     */
    public static function implode(string $originalString, string $cnSeparator, string $otherSeparator = ''): string
    {
        $str_array = preg_split('/(?<!^)(?!$)/u', $originalString);
        $targetString = "";
        foreach ($str_array as $i => $iValue) {
            $tempString = $iValue;
            $targetString .= $tempString;
            if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $tempString)) {
                $targetString .= $cnSeparator;
            } else {
                $targetString .= $otherSeparator;
            }
        }
        return rtrim(rtrim($targetString, $cnSeparator), $otherSeparator);
    }

    /**
     * @param string $originalString
     * @param string $separator
     * @return string
     * 字符串顺序打乱
     */
    public static function shuffle(string $originalString, string $separator = ''): string
    {
        $arr = self::convert2array($originalString);
        shuffle($arr);
        return implode($separator, $arr);
    }


    /**
     * @param int $length 获取长度
     * @param int|null $type 随机类型
     * @param string $addChars 追加字符串
     * @return string
     * 获取指定长度的随机字母数字组合的字符串
     * @throws Exception
     */
    public static function random(int $length = 6, int $type = null, string $addChars = ''): string
    {
        $str = '';
        $chars = match ($type) {
            0 => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars,
            1 => str_repeat('0123456789', 3),
            2 => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars,
            3 => 'abcdefghijklmnopqrstuvwxyz' . $addChars,
            4 => "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书" . $addChars,
            default => 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars,
        };
        if ($length > 10) {
            $chars = $type === 1 ? str_repeat($chars, $length) : str_repeat($chars, 5);
        }
        if ($type !== 4) {
            $chars = str_shuffle($chars);
            $str = substr($chars, 0, $length);
        } else {
            for ($i = 0; $i < $length; $i++) {
                $str .= mb_substr($chars, floor(random_int(0, mb_strlen($chars, 'utf-8') - 1)), 1);
            }
        }
        return $str;
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     * 返回随机纯数字字符串
     */
    public static function randomNumber(int $length = 2): string
    {
        return self::random($length, 1);
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     * 返回随机纯大写字母字符串
     */
    public static function randomUpper(int $length = 6): string
    {
        return self::random($length, 2);
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     * 返回随机纯大写字母字符串
     */
    public static function randomLower(int $length = 6): string
    {
        return self::random($length, 3);
    }
}
