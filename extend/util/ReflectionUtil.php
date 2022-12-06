<?php

namespace util;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ReflectionUtil
{
    /**
     * @param mixed $obj 对象
     * @param string $propertyName 属性名
     * @return mixed
     * @throws ReflectionException 获取对象的属性值
     * 获取对象属性的值
     */
    public static function getPropertyValue(mixed $obj, string $propertyName): mixed
    {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

    /**
     * @param string $class 类
     * @param string $methodName 方法
     * @param string ...$annotationClass 需要获取的注解
     * @return array{class-string:ReflectionMethod}
     * @throws ReflectionException
     * @Author: WasonChueng
     * @Data: 2022/7/29
     * 反射获取类方法的指定注解
     */
    public static function getAttributesByMethod(string $class, string $methodName, string ...$annotationClass): array
    {
        $ref = new ReflectionClass($class);
        $method = $ref->getMethod($methodName);
        $result = [];
        foreach ($annotationClass as $annotation) {
            $attributes = $method->getAttributes($annotation);
            if ($attributes) {
                foreach ($attributes as $attribute) {
                    $result[$annotation][] = $attribute;
                }
            } else {
                $result[$annotation] = [];
            }
        }
        return $result;
    }

    /**
     * @param object|string $class
     * @param string $attribute
     * @return array
     * @throws ReflectionException
     * 反射获取 方法包含的注解
     */
    public static function getMethodWithAttribute(object|string $class, string $attribute): array
    {
        $ref = new ReflectionClass($class);
        $methods = $ref->getMethods();
        $result = [];
        foreach ($methods as $method) {
            // 获取method的注解
            $attributes = $method->getAttributes($attribute);
            if ($attributes) {
                $method->setAccessible(true);
                $result[$method->getName() . '()'] = [$method->invoke($class), $attributes];
            }
        }
        return $result;
    }

    /**
     * @param object|string $instance
     * @param string $attribute
     * @return array
     * 获取一个类中 包含某个注解的属性成员
     * @throws ReflectionException
     */
    public static function getPropertyWithAttribute(object|string $instance, string $attribute): array
    {
        $ref = new ReflectionClass($instance);
        $propertys = $ref->getProperties();
        $result = [];
        foreach ($propertys as $property) {
            $attributes = $property->getAttributes($attribute);
            if ($attributes) {
                $property->setAccessible(true);
                $result[$property->getName()] = [$property->getValue($instance), $attributes];
            }
        }
        return $result;
    }

    /**
     * @param object|string $class 类名或者对象实例
     * @return array
     * @throws ReflectionException 获取类的属性和值
     * 获取对象或者类的属性的值
     */
    public static function getPropertyValueOrDefaultValue(object|string $class): array
    {
        $ref = new ReflectionClass($class);
        $propertys = $ref->getProperties();
        $result = [];
        foreach ($propertys as $property) {
            $property->setAccessible(true);
            if (\is_object($class)) {
                $result[$property->getName()] = $property->getValue($class);
            } else {
                $result[$property->getName()] = $property->getDefaultValue();
            }
        }
        return $result;
    }
}
