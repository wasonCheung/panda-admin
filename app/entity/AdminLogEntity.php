<?php

declare(strict_types=1);

namespace app\entity;

class AdminLogEntity
{
    public const PRIMARY_KEY = 'id';
    public const ID = 'id';
    public const ADMIN_ID = 'admin_id';
    public const ADMIN_NAME = 'admin_name';
    public const URL = 'url';
    public const TITLE = 'title';
    public const DATA = 'data';
    public const IP = 'ip';
    public const USER_AGENT = 'user_agent';
    public const PS = 'ps';
    public const CREATE_TIME = 'create_time';
    public const UPDATE_TIME = 'update_time';

    private array $fields = [
        'id' => null,
        'admin_id' => null,
        'admin_name' => null,
        'url' => null,
        'title' => null,
        'data' => null,
        'ip' => null,
        'user_agent' => null,
        'ps' => null,
        'create_time' => null,
        'update_time' => null,
    ];

    private array $extra = [];

    public function __construct(array $fields = [])
    {
        $this->setArray($fields);
    }

    public function toArray(bool $filtration = false): array
    {
        if (!$filtration){ return $this->fields; }
        return array_filter($this->fields, function ($item){ return $item !== null;});
    }

    public function setArray(array $fields): self
    {
        if (empty($fields)){ return $this; }
        foreach ($this->fields as $key => $value) {
           $this->fields[$key] = $fields[$key] ?? null;
        }
        return $this;
    }

    public function restArray(): self
    {
        foreach ($this->fields as $key => $value) {
           $this->fields[$key] = null;
        }
        return $this;
    }

    public function __setExtra(string $name, $value): self
    {
        $this->extra[$name] = $value;
        return $this;
    }

    public function __getExtra(string|null $name = null, mixed $default = null): mixed
    {
        if ($name === null) { return $this->extra; }
        return $this->extra[$name] ?? $default;
    }

    public function __toString(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE );
    }

    public function __serialize(): array
    {
        return $this->toArray(true);
    }

    public function __unserialize(array $fields): void
    {
        $this->setArray($fields);
    }

    public function getId(): mixed
    {
        return $this->fields['id'];
    }

    /**
     * @param int $value ID
     * @return self
     */
    public function setId(int $value): self
    {
        $this->fields['id'] = $value;
        return $this;
    }

    public function getAdminId(): mixed
    {
        return $this->fields['admin_id'];
    }

    /**
     * @param int $value 管理员ID
     * @return self
     */
    public function setAdminId(int $value): self
    {
        $this->fields['admin_id'] = $value;
        return $this;
    }

    public function getAdminName(): mixed
    {
        return $this->fields['admin_name'];
    }

    /**
     * @param mixed $value 管理员用户名
     * @return self
     */
    public function setAdminName(mixed $value): self
    {
        $this->fields['admin_name'] = $value;
        return $this;
    }

    public function getUrl(): mixed
    {
        return $this->fields['url'];
    }

    /**
     * @param mixed $value 操作Url
     * @return self
     */
    public function setUrl(mixed $value): self
    {
        $this->fields['url'] = $value;
        return $this;
    }

    public function getTitle(): mixed
    {
        return $this->fields['title'];
    }

    /**
     * @param mixed $value 日志标题
     * @return self
     */
    public function setTitle(mixed $value): self
    {
        $this->fields['title'] = $value;
        return $this;
    }

    public function getData(): mixed
    {
        return $this->fields['data'];
    }

    /**
     * @param mixed $value 请求数据
     * @return self
     */
    public function setData(mixed $value): self
    {
        $this->fields['data'] = $value;
        return $this;
    }

    public function getIp(): mixed
    {
        return $this->fields['ip'];
    }

    /**
     * @param mixed $value IP
     * @return self
     */
    public function setIp(mixed $value): self
    {
        $this->fields['ip'] = $value;
        return $this;
    }

    public function getUserAgent(): mixed
    {
        return $this->fields['user_agent'];
    }

    /**
     * @param mixed $value 客户端信息
     * @return self
     */
    public function setUserAgent(mixed $value): self
    {
        $this->fields['user_agent'] = $value;
        return $this;
    }

    public function getPs(): mixed
    {
        return $this->fields['ps'];
    }

    /**
     * @param mixed $value 备注信息
     * @return self
     */
    public function setPs(mixed $value): self
    {
        $this->fields['ps'] = $value;
        return $this;
    }

    public function getCreateTime(): mixed
    {
        return $this->fields['create_time'];
    }

    /**
     * @param int $value 创建时间
     * @return self
     */
    public function setCreateTime(int $value): self
    {
        $this->fields['create_time'] = $value;
        return $this;
    }

    public function getUpdateTime(): mixed
    {
        return $this->fields['update_time'];
    }

    /**
     * @param int $value 更新时间
     * @return self
     */
    public function setUpdateTime(int $value): self
    {
        $this->fields['update_time'] = $value;
        return $this;
    }
}
