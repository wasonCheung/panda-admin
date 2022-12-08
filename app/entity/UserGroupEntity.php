<?php

declare(strict_types=1);

namespace app\entity;

class UserGroupEntity
{
    public const PRIMARY_KEY = 'id';
    public const ID = 'id';
    public const STATUS = 'status';
    public const NAME = 'name';
    public const RULES = 'rules';
    public const COINS_FOR_DAY = 'coins_for_day';
    public const COINS_FOR_MONTH = 'coins_for_month';
    public const COINS_FOR_YEAR = 'coins_for_year';
    public const COINS_FOR_INFINITE = 'coins_for_infinite';
    public const CREATE_TIME = 'create_time';
    public const UPDATE_TIME = 'update_time';

    private array $fields = [
        'id' => null,
        'status' => null,
        'name' => null,
        'rules' => null,
        'coins_for_day' => null,
        'coins_for_month' => null,
        'coins_for_year' => null,
        'coins_for_infinite' => null,
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
     * @param int $value 用户组id
     * @return self
     */
    public function setId(int $value): self
    {
        $this->fields['id'] = $value;
        return $this;
    }

    public function getStatus(): mixed
    {
        return $this->fields['status'];
    }

    /**
     * @param int $value 状态:0=禁用,1=启用
     * @return self
     */
    public function setStatus(int $value): self
    {
        $this->fields['status'] = $value;
        return $this;
    }

    public function getName(): mixed
    {
        return $this->fields['name'];
    }

    /**
     * @param mixed $value 用户组名
     * @return self
     */
    public function setName(mixed $value): self
    {
        $this->fields['name'] = $value;
        return $this;
    }

    public function getRules(): mixed
    {
        return $this->fields['rules'];
    }

    /**
     * @param mixed $value 权限规则ID
     * @return self
     */
    public function setRules(mixed $value): self
    {
        $this->fields['rules'] = $value;
        return $this;
    }

    public function getCoinsForDay(): mixed
    {
        return $this->fields['coins_for_day'];
    }

    /**
     * @param int $value 包日硬币数量
     * @return self
     */
    public function setCoinsForDay(int $value): self
    {
        $this->fields['coins_for_day'] = $value;
        return $this;
    }

    public function getCoinsForMonth(): mixed
    {
        return $this->fields['coins_for_month'];
    }

    /**
     * @param int $value 包月硬币数量
     * @return self
     */
    public function setCoinsForMonth(int $value): self
    {
        $this->fields['coins_for_month'] = $value;
        return $this;
    }

    public function getCoinsForYear(): mixed
    {
        return $this->fields['coins_for_year'];
    }

    /**
     * @param int $value 包年硬币数量
     * @return self
     */
    public function setCoinsForYear(int $value): self
    {
        $this->fields['coins_for_year'] = $value;
        return $this;
    }

    public function getCoinsForInfinite(): mixed
    {
        return $this->fields['coins_for_infinite'];
    }

    /**
     * @param int $value 无限日期硬币数量
     * @return self
     */
    public function setCoinsForInfinite(int $value): self
    {
        $this->fields['coins_for_infinite'] = $value;
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
