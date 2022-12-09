<?php

use plugin\__kernel\tools\Code;

/**
 * @param string $string
 * @return int
 * @Data: 2022/12/9
 * @Author: WasonCheung
 * @Description: 获取编码
 */
function __code(string $string): int
{
    return Code::make($string);
}
