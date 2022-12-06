<?php

namespace util;

class FileCacheUtil
{
    private mixed $driver;

    public static function instance(): self
    {
        return new self();
    }

    public function driver($driver): self
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @param string $file 文件
     * @param int $expire 过期时间
     * @return array
     * 获取文本数组缓存
     */
    public function txtArray(string $file, int $expire = 0): array
    {
        if (!is_file($file)) {
            return [];
        }
        return $this->filecontentByLastModified(static function (string $file) {
            return file($file, FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES);
        }, $file, $expire, 'panda_cache_txtarr');
    }

    /**
     * @param callable $callback 回调函数 其值会被缓存
     * @param string $file 文件名或目录名
     * @param int $expire 过期时间
     * @param string $tag 缓存标签
     * @return array{
     *           last_modify:string,
     *           content:mixed,
     *        }
     * 文件内容缓存 实时监控文件更新
     */
    public function filecontentByLastModified(
        callable $callback,
        string $file,
        int $expire = 0,
        string $tag = ''
    ): array {
        // 清楚文件缓存
        clearstatcache();
        $cache = $this->driver->get($file) ?: [];
        if (empty($cache) || $cache['last_modify'] !== filemtime($file)) {
            $call = $callback($file);
            if (empty($call)) {
                $this->driver->delete($file);
            } else {
                $cache = ['last_modify' => filemtime($file), 'content' => $call];
                if ($tag) {
                    $this->driver->tag($tag)->set($file, $cache, $expire);
                } else {
                    $this->driver->set($file, $cache, $expire);
                }
            }
        }
        return $cache;
    }

    /**
     * @param string $dir 目录
     * @param string $pattern 指定类型
     * @param int $expire 过期时间
     * @return array
     * 获取目录的文件列表缓存
     */
    public function filelist(string $dir, string $pattern = '*', int $expire = 0): array
    {
        if (!is_dir($dir)) {
            return [];
        }
        return $this->filecontentByLastModified(function (string $dir) use ($pattern) {
            return FileUtil::globScanDirAll($dir, $pattern);
        }, $dir, $expire, 'panda_cache_filelist');
    }

    /**
     * @param string $file 文件
     * @param int $expire 过期时间
     * @return string
     * 文本文件内容缓存
     */
    public function txtContent(string $file, int $expire = 0): string
    {
        if (!is_file($file)) {
            return '';
        }
        $cache = $this->filecontentByLastModified(function (string $file) {
            return file_get_contents($file);
        }, $file, $expire, 'panda_cache_txtcontent');
        return $cache['content'] ?? '';
    }
}
