<?php

namespace util;

class FileUtil
{
    /**
     * @param string $file 文件路径
     * @param array $arr 数组
     * @return bool
     * 将数组输出到文件中
     */
    public static function arr2file(string $file, array $arr): bool
    {
        $con = var_export($arr, true);
        $con = "<?php\nreturn $con;";
        return self::makefile($file, $con);
    }

    /**
     * @param string $path 文件路径
     * @param string $content 文件内容
     * @return bool
     * 新建本地文件
     */
    public static function makefile(string $path, string $content = ''): bool
    {
        $dir = \dirname($path);
        if (!is_dir($dir)) {
            self::makedir($dir);
        }
        return file_put_contents($path, $content);
    }


    /**
     * @param string $file 文件路径
     * @return bool
     * 删除指定文件
     */
    public static function delfile(string $file): bool
    {
        return is_file($file) && unlink($file);
    }

    /**
     * @param string $path 目录地址
     * @param int $mode
     * @return bool
     * 创建目录
     */
    public static function makedir(string $path, int $mode = 0777): bool
    {
        return mkdir($path, $mode, true);
    }

    /**
     * @param string $dir 目录
     * @return string
     * 目录分隔符转换
     */
    public static function dirSeparatorConvert(string $dir): string
    {
        if (DIRECTORY_SEPARATOR === '/') {
            $dir = str_replace('\\', DIRECTORY_SEPARATOR, $dir);
        } elseif (DIRECTORY_SEPARATOR === '\\') {
            $dir = str_replace('/', DIRECTORY_SEPARATOR, $dir);
        }
        if (!str_ends_with($dir, DIRECTORY_SEPARATOR)) {
            $dir .= DIRECTORY_SEPARATOR;
        }
        return $dir;
    }

    /**
     * @param string $dir 目录
     * @param string $pattern 删除规则
     * @return bool
     * 删除指定目录下的所有文件
     */
    public static function deldir(string $dir, string $pattern = '*'): bool
    {
        // 删除当前符合条件的文件
        foreach (self::globScanDir($dir, $pattern) as $file) {
            self::delfile($file);
        }
        // 扫描子目录
        foreach (self::globScanDir($dir) as $subFile) {
            if (is_dir($subFile)) {
                self::deldir($subFile, $pattern);
            }
        }

        return @rmdir($dir);
    }

    /**
     * @param string $dir 目录
     * @param string $pattern 扫描规则
     * @return bool|array 返回全路径 文件数组
     * 扫描目录下的文件
     */
    public static function globScanDir(string $dir, string $pattern = '*'): bool|array
    {
        return glob(self::dirSeparatorConvert($dir) . $pattern ?: '*');
    }

    /**
     * @param string $dir 起始目录
     * @param string $pattern 文件正则
     * @param array $result
     * @return array
     * 扫描目录下的所有文件包括子目录
     */
    public static function globScanDirAll(string $dir, string $pattern = '*', array &$result = []): array
    {
        // 查找当前目录 获取符合条件的文件
        foreach (self::globScanDir($dir, $pattern) as $file) {
            $result[] = $file;
        }
        // 查找子目录
        foreach (self::globScanDir($dir) as $subFile) {
            if (is_dir($subFile)) {
                self::globScanDirAll($subFile, $pattern, $result);
            }
        }
        return $result;
    }

    /**
     * @param string $dir 目录
     * @param int $mode 默认返回文件和目录 1 仅文件 2 仅目录
     * @param string|array $pattern 文件名规则
     * @return array
     * 扫描目录
     */
    public static function scandir(string $dir, int $mode = 0, string|array $pattern = ''): array
    {

        return array_filter(scandir($dir), static function ($item) use ($dir, $pattern, $mode) {
            if ($item === '.' || $item === '..') {
                return false;
            }

            if ($pattern && !str_contains($item, $pattern)) {
                return false;
            }

            if ($mode === 1 && !is_file($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

            if ($mode === 2 && !is_dir($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

            return true;
        });
    }
}
