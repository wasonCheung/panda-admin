<?php
namespace plugin\__panda;

use think\Response;
use think\response\Json;
use think\response\Jsonp;
use think\response\View;

/**
 * @Data: 2022/11/23
 * @Author: WasonCheung
 * @Description: 数据标准
 */
class StandardData
{
    /**
     * @var bool 成功|失败 一个请求达到目的就是成功
     */
    private bool $status = true;

    /**
     * @var int 响应码
     */
    private int $code = 1;

    /**
     * @var string 提示信息
     */
    private string $msg = '';

    /**
     * @var array 数据体
     */
    private array $data = [];

    /**
     * @var array 选项
     */
    private array $options = [];

    /**
     * @var array 响应头
     */
    private array $headers = [];

    /**
     * @var array 发生错误时，错误的堆栈信息
     */
    private array $error = [];

    public static function success(): self
    {
        $obj = new self();
        $obj->setStatus(true);
        return $obj;
    }

    public static function error(): self
    {
        $obj = new self();
        $obj->setStatus(false);
        return $obj;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getMsg(): string
    {
        return $this->msg;
    }

    public function setMsg(string $msg): self
    {
        $this->msg = $msg;
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getError(): array
    {
        return $this->error;
    }

    public function setError(array $error): self
    {
        $this->error = $error;
        return $this;
    }

    public function toJson(): Json
    {
        $this->options = array_merge(
            $this->options,
            ['json_encode_param' => JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES]
        );
        return Response::create($this->toArray(), 'json')
            ->header($this->headers)
            ->options($this->options);
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'msg' => $this->msg,
            'data' => $this->data,
            'timezone' => date_default_timezone_get(),
            'timestamp' => time(),
        ];
    }

    public function toJsonp(): Jsonp
    {
        return Response::create($this->toArray(), 'jsonp')->header($this->headers)->options($this->options);
    }

    public function toView(string $template = '', $filter = null): View
    {
        return Response::create($template, 'view', 200)->assign($this->toArray())->filter($filter);
    }
}
