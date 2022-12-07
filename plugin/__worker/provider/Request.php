<?php

namespace plugin\__worker\provider;

use think\App;
use think\exception\HttpException;
use think\Request as ThinkRequest;
use Workerman\Protocols\Http\Request as WorkerRequest;

/**
 * @Data: 2022/12/1
 * @Author: WasonCheung
 * @Description: workerman 环境下的request
 */
class Request extends ThinkRequest
{
    protected $filter = [
        'strip_tags',
        'htmlspecialchars',
        'trim',
    ];

    public static function __make(App $app): Request
    {
        $thinkRequest = parent::__make($app);

        if (!$app->has(WorkerRequest::class)) {
            throw new HttpException('Request 创建对象失败: 实例容器中没有 WorkerRequest');
        }

        $workerRequest = $app->get(WorkerRequest::class);

        // 初始化对象
        $thinkRequest
            ->withGet($workerRequest->get())
            ->withPost($workerRequest->post())
            ->withFiles($workerRequest->file())
            ->withHeader($workerRequest->header())
            ->withCookie($workerRequest->cookie())
            ->setPathinfo(ltrim($workerRequest->path(), '/'));

        return $thinkRequest;
    }
}
