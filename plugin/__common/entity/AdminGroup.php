<?php

declare(strict_types=1);

namespace plugin\__common\entity;

class AdminGroup extends \plugin\__kernel\abstracts\BaseEntity
{
    /** 主键 */
    public const PRIMARY_KEY = 'id';

    /** 主键 */
    public const ID = 'id';

    /** 组名 */
    public const NAME = 'name';

    /** 状态:0=禁用,1=启用 */
    public const STATUS = 'status';

    /** 权限规则ID */
    public const RULES = 'rules';

    /** 创建时间 */
    public const CREATE_TIME = 'create_time';

    /** 更新时间 */
    public const UPDATE_TIME = 'update_time';

    protected array $fields = [
        'id' => null,
        'name' => null,
        'status' => null,
        'rules' => null,
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

    public function getName(): mixed
    {
        return $this->fields['name'];
    }

    public function setName(mixed $value): self
    {
        $this->fields['name'] = $value;
        return $this;
    }

    public function getStatus(): mixed
    {
        return $this->fields['status'];
    }

    public function setStatus(int $value): self
    {
        $this->fields['status'] = $value;
        return $this;
    }

    public function getRules(): mixed
    {
        return $this->fields['rules'];
    }

    public function setRules(mixed $value): self
    {
        $this->fields['rules'] = $value;
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
