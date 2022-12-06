<?php

namespace util;

class RedisUtil
{
    private mixed $redisDriver;

    public static function instance(): self
    {
        return new self();
    }

    public function driver($redisDriver): self
    {
        $this->redisDriver = $redisDriver;
        return $this;
    }

    /**
     * @param string $pattern
     * @return array 返回键集合
     * 扫描redis中的键
     */
    public function scanKeys(string $pattern): array
    {
        $res = [];
        $iterator = null;
        while (($keys =  $this->redisDriver->scan($iterator, $pattern, 500)) !== false) {
            $res[] = $keys;
        }
        return $res;
    }
}
