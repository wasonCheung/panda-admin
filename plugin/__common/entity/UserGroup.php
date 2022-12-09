<?php

declare(strict_types=1);

namespace plugin\__common\entity;

class UserGroup extends \plugin\__kernel\abstracts\BaseEntity
{
    /** 用户组id */
    public const PRIMARY_KEY = 'id';

    /** 用户组id */
    public const ID = 'id';

    /** 状态:0=禁用,1=启用 */
    public const STATUS = 'status';

    /** 用户组名 */
    public const NAME = 'name';

    /** 权限规则ID */
    public const RULES = 'rules';

    /** 包日硬币数量 */
    public const COINS_FOR_DAY = 'coins_for_day';

    /** 包月硬币数量 */
    public const COINS_FOR_MONTH = 'coins_for_month';

    /** 包年硬币数量 */
    public const COINS_FOR_YEAR = 'coins_for_year';

    /** 无限日期硬币数量 */
    public const COINS_FOR_INFINITE = 'coins_for_infinite';

    /** 创建时间 */
    public const CREATE_TIME = 'create_time';

    /** 更新时间 */
    public const UPDATE_TIME = 'update_time';

    protected array $fields = [
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

    public function getId(): mixed
    {
        return $this->fields['id'];
    }

    public function setId(int $value): self
    {
        $this->fields['id'] = $value;
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

    public function getName(): mixed
    {
        return $this->fields['name'];
    }

    public function setName(mixed $value): self
    {
        $this->fields['name'] = $value;
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

    public function getCoinsForDay(): mixed
    {
        return $this->fields['coins_for_day'];
    }

    public function setCoinsForDay(int $value): self
    {
        $this->fields['coins_for_day'] = $value;
        return $this;
    }

    public function getCoinsForMonth(): mixed
    {
        return $this->fields['coins_for_month'];
    }

    public function setCoinsForMonth(int $value): self
    {
        $this->fields['coins_for_month'] = $value;
        return $this;
    }

    public function getCoinsForYear(): mixed
    {
        return $this->fields['coins_for_year'];
    }

    public function setCoinsForYear(int $value): self
    {
        $this->fields['coins_for_year'] = $value;
        return $this;
    }

    public function getCoinsForInfinite(): mixed
    {
        return $this->fields['coins_for_infinite'];
    }

    public function setCoinsForInfinite(int $value): self
    {
        $this->fields['coins_for_infinite'] = $value;
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
