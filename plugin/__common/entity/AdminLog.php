<?php

declare(strict_types=1);

namespace plugin\__common\entity;

class AdminLog extends \plugin\__kernel\abstracts\BaseEntity
{
    /** ID */
    public const PRIMARY_KEY = 'id';

    /** ID */
    public const ID = 'id';

    /** 管理员ID */
    public const ADMIN_ID = 'admin_id';

    /** 管理员用户名 */
    public const ADMIN_NAME = 'admin_name';

    /** 操作Url */
    public const URL = 'url';

    /** 日志标题 */
    public const TITLE = 'title';

    /** 请求数据 */
    public const DATA = 'data';

    /** IP */
    public const IP = 'ip';

    /** 客户端信息 */
    public const USER_AGENT = 'user_agent';

    /** 备注信息 */
    public const PS = 'ps';

    /** 创建时间 */
    public const CREATE_TIME = 'create_time';

    /** 更新时间 */
    public const UPDATE_TIME = 'update_time';

    protected array $fields = [
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

    public function getId(): mixed
    {
        return $this->fields['id'];
    }

    public function setId(int $value): self
    {
        $this->fields['id'] = $value;
        return $this;
    }

    public function getAdminId(): mixed
    {
        return $this->fields['admin_id'];
    }

    public function setAdminId(int $value): self
    {
        $this->fields['admin_id'] = $value;
        return $this;
    }

    public function getAdminName(): mixed
    {
        return $this->fields['admin_name'];
    }

    public function setAdminName(mixed $value): self
    {
        $this->fields['admin_name'] = $value;
        return $this;
    }

    public function getUrl(): mixed
    {
        return $this->fields['url'];
    }

    public function setUrl(mixed $value): self
    {
        $this->fields['url'] = $value;
        return $this;
    }

    public function getTitle(): mixed
    {
        return $this->fields['title'];
    }

    public function setTitle(mixed $value): self
    {
        $this->fields['title'] = $value;
        return $this;
    }

    public function getData(): mixed
    {
        return $this->fields['data'];
    }

    public function setData(mixed $value): self
    {
        $this->fields['data'] = $value;
        return $this;
    }

    public function getIp(): mixed
    {
        return $this->fields['ip'];
    }

    public function setIp(mixed $value): self
    {
        $this->fields['ip'] = $value;
        return $this;
    }

    public function getUserAgent(): mixed
    {
        return $this->fields['user_agent'];
    }

    public function setUserAgent(mixed $value): self
    {
        $this->fields['user_agent'] = $value;
        return $this;
    }

    public function getPs(): mixed
    {
        return $this->fields['ps'];
    }

    public function setPs(mixed $value): self
    {
        $this->fields['ps'] = $value;
        return $this;
    }

    public function getCreateTime(): mixed
    {
        return $this->fields['create_time'];
    }

    public function setCreateTime(int $value): self
    {
        $this->fields['create_time'] = $value;
        return $this;
    }

    public function getUpdateTime(): mixed
    {
        return $this->fields['update_time'];
    }

    public function setUpdateTime(int $value): self
    {
        $this->fields['update_time'] = $value;
        return $this;
    }
}
