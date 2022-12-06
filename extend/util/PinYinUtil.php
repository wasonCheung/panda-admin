<?php

namespace util;

class PinYinUtil
{
    private array $date = [];

    public function __construct()
    {
        $data = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'res' . DIRECTORY_SEPARATOR . 'pinyin.dat');
        $rows = explode('|', $data);
        foreach ($rows as $v) {
            [$py, $vals] = explode(':', $v);
            $chars = explode(',', $vals);
            foreach ($chars as $char) {
                $this->date[$char] = $py;
            }
        }
    }

    public static function instance(): self
    {
        return new self();
    }

    /**
     * @param string $originalString 原始字符串
     * @param string $cnSpearator 中文字符分割
     * @param string $otherSpearator 其它字符分割
     * @return string
     * 将中文字符串转换成拼音的形式
     */
    public function cn2pinYins(string $originalString, string $cnSpearator = '', string $otherSpearator = ''): string
    {
        $str_array = preg_split('/(?<!^)(?!$)/u', $originalString);
        $targetString = "";
        foreach ($str_array as $i => $iValue) {
            $tempString = $iValue;
            if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $tempString)) {
                $targetString .= $this->cn2pinyin($tempString);
                $targetString .= $cnSpearator;
            } else {
                $targetString .= $tempString;
                $targetString .= $otherSpearator;
            }
        }
        return rtrim(rtrim($targetString, $cnSpearator), $otherSpearator);
    }

    /**
     * @param string $originalString 原始字符串
     * @param string $cnSepearator 中文字符分割
     * @param string $otherSepearator 其它字符分割
     * @return string
     * 将中文转换拼音汉字混合的形式
     */
    public function cnWithPinYin(
        string $originalString,
        string $cnSepearator = '',
        string $otherSepearator = ''
    ): string {
        $str_array = preg_split('/(?<!^)(?!$)/u', $originalString);
        $targetString = "";
        foreach ($str_array as $iValue) {
            $tempString = $iValue;
            if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $tempString)) {
                $targetString .= $tempString . $this->cn2pinyin($tempString);
                $targetString .= $cnSepearator;
            } else {
                $targetString .= $tempString;
                $targetString .= $otherSepearator;
            }
        }
        return rtrim(rtrim($targetString, $cnSepearator), $otherSepearator);
    }


    /**
     * @param string $aString
     * @return string
     * 将一个中文字符串转换成拼音
     */
    public function cn2pinyin(string $aString): string
    {
        return $this->date[$aString] ?? $aString;
    }
}
