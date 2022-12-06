<?php

namespace util;

class ClassUtil
{
    /**
     * 获取类名(不包含命名空间)
     * @param mixed $class 类名
     * @return string
     */
    public static function basename(mixed $class): string
    {
        $class = \is_object($class) ? \get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }

    /**
     *获取一个类里所有用到的trait，包括父类的
     * @param mixed $class 类名
     * @return array
     */
    public static function allUses(mixed $class): array
    {
        if (\is_object($class)) {
            $class = \get_class($class);
        }
        $results = [];
        $classes = array_merge([$class => $class], class_parents($class));
        foreach ($classes as $item) {
            $results += trait_uses_recursive($item);
        }
        return array_unique($results);
    }

    /**
     * 获取一个trait里所有引用到的trait
     * @param string $trait Trait
     * @return array
     */
    public static function traitUses(string $trait): array
    {
        $traits = class_uses($trait);
        foreach ($traits as $item) {
            $traits += trait_uses_recursive($item);
        }
        return $traits;
    }
}
