<?php

namespace plugin\__worker\provider;

use think\Cookie as ThinkCookie;
use Workerman\Protocols\Http\Response as WorkerResponse;

class Cookie extends ThinkCookie
{
    /**
     * 保存Cookie
     * @access public
     * @param string $name cookie名称
     * @param string $value cookie值
     * @param int $expire cookie过期时间
     * @param string $path 有效的服务器路径
     * @param string $domain 有效域名/子域名
     * @param bool $secure 是否仅仅通过HTTPS
     * @param bool $httponly 仅可通过HTTP访问
     * @param string $samesite 防止CSRF攻击和用户追踪
     * @return void
     */
    protected function saveCookie(
        string $name,
        string $value,
        int $expire,
        string $path,
        string $domain,
        bool $secure,
        bool $httponly,
        string $samesite
    ): void {
        app(WorkerResponse::class)->cookie(
            $name,
            $value,
            ($expire === 0 ? null : $expire),
            $path,
            $domain,
            $secure,
            $httponly,
            $samesite
        );
    }
}
