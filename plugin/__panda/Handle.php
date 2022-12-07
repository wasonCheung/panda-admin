<?php

namespace plugin\__panda;

use think\exception\ValidateException;
use think\Request;
use think\Response;
use Throwable;

/**
 * @Project: pandacms-v1.0
 * @Author: wasonChueng
 * @Data: 2022/8/8
 * @Class: framework/Handle
 * @Description: 异常处理接口
 */
class Handle extends \think\exception\Handle
{
    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 验证器异常处理
        if ($e instanceof ValidateException) {
            return json($e->getError());
        }
        // 其他错误交给系统处理
        return parent::render($request, $e);
    }
}
