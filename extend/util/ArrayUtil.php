<?php

namespace util;

use Exception;

class ArrayUtil
{
    /**
     * @param array $array
     * @param null $seed
     * @return mixed
     * @throws Exception 数组打乱顺序
     */
    public static function shuffle(array $array, $seed = null): array
    {
        if (is_null($seed)) {
            shuffle($array);
        } else {
            mt_srand($seed);
            usort($array, static function () {
                return random_int(-1, 1);
            });
        }
        return $array;
    }

    /**
     * @param array $array
     * @return bool
     * 判断是个数组 是否是关联数组
     */
    public static function isAssociative(array $array): bool
    {
        $keys = array_keys($array);
        return array_keys($keys) !== $keys;
    }

    /**
     * 递归 根据数据的键 对数组进行升序排序
     * @param array $array
     * @return array
     */
    public static function ascByKey(array $array): array
    {

        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = self::ascByKey($value);
            }
        }
        if (self::isAssociative($array)) {
            ksort($array);
        } else {
            sort($array);
        }
        return $array;
    }

    /**
     * 递归 根据数据的键 对数组进行降序排序
     * @param array $array
     * @return array
     */
    public static  function descByKey(array $array): array
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = self::descByKey($value);
            }
        }
        if (self::isAssociative($array)) {
            krsort($array);
        } else {
            rsort($array);
        }
        return $array;
    }


    /**
     * 递归 根据数组的值 对数组进行降序排序
     * @param array $array
     * @return array
     */
    public static  function descByValue(array $array): array
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = self::descByValue($value);
            }
        }
        if (self::isAssociative($array)) {
            arsort($array);
        } else {
            rsort($array);
        }
        return $array;
    }

    /**
     * 递归 根据数组的值 对数组进行升序排序
     * @param array $array
     * @return array
     */
    public static function ascByValue(array $array): array
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = self::ascByValue($value);
            }
        }
        if ( self::isAssociative($array)) {
            asort($array);
        } else {
            sort($array);
        }
        return $array;
    }

    /**
     * @param array $array
     * @return string
     * 将数组转换成查询字符串
     */
   public static function convert2queryString(array $array): string
    {
        return http_build_query($array, null, '&', PHP_QUERY_RFC3986);
    }

    /**
     * @param array $array
     * @param int $number
     * @return mixed
     * 从数组中 获取指定数量的随机项
     */
    public static function random(array $array, int $number = 1): array
    {
        $count = count($array);
        if ($count === 0) {
            return [];
        }
        if ($number > count($array)) {
            return $array[array_rand($array)];
        }
        $keys = array_rand($array, $number);
        $results = [];
        foreach ((array)$keys as $key) {
            $results[] = $array[$key];
        }
        return $results;
    }

    /**
     * @param array $array
     * @param mixed $value
     * @param mixed $key
     * @return array
     * 向数组的开头插入一个元素
     */
    public static function prepend(array $array, mixed $value, mixed $key = null): array
    {
        if (is_null($key)) {
            array_unshift($array, $value);
        } else {
            $array = [$key => $value] + $array;
        }
        return $array;
    }

    /**
     * @param array $array
     * @param string|null $name 键名 .分割
     * @param mixed $default 不存在时返回
     * @return mixed
     * 数组快速访问获取值
     */
    public static function getByDot(array $array, string $name = null, mixed $default = null): mixed
    {
        if ($name === null) {
            return $array;
        }
        if (!str_contains($name, '.')) {
            return $array[$name] ?? $default;
        }
        $name = explode('.', $name);
        foreach ($name as $val) {
            if (isset($array[$val])) {
                $array = $array[$val];
            } else {
                return $default;
            }
        }
        return $array;
    }

}