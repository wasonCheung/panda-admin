<?php

declare(strict_types=1);

namespace app\entity;

/**
 * @property mixed $id ID
 * @property mixed $pid 权限归属
 * @property mixed $status 状态:0=禁用,1=启用
 * @property mixed $type 类型:1=menu_dir=菜单目录,2=menu=菜单项,3=button=页面按钮
 * @property mixed $title 规则标题
 * @property mixed $name 规则名称(全英文小写)
 * @property mixed $path 路由路径
 * @property mixed $icon 图标
 * @property mixed $menu_type 菜单类型:tab=选项卡,link=链接,iframe=Iframe
 * @property mixed $url Url
 * @property mixed $component vue组件路径
 * @property mixed $keepalive 缓存:0=关闭,1=开启
 * @property mixed $ps 备注
 * @property mixed $sort 排序
 * @property mixed $create_time 创建时间
 * @property mixed $update_time 更新时间
 */
class RuleEntity
{
    public const TABLE_NAME = 'panda_rule';
    public const PRIMARY_KEY = 'id';
    public const ID = 'id';
    public const PID = 'pid';
    public const STATUS = 'status';
    public const TYPE = 'type';
    public const TITLE = 'title';
    public const NAME = 'name';
    public const PATH = 'path';
    public const ICON = 'icon';
    public const MENU_TYPE = 'menu_type';
    public const URL = 'url';
    public const COMPONENT = 'component';
    public const KEEPALIVE = 'keepalive';
    public const PS = 'ps';
    public const SORT = 'sort';
    public const CREATE_TIME = 'create_time';
    public const UPDATE_TIME = 'update_time';

    protected array $fields = [
        'id' => null,
        'pid' => null,
        'status' => null,
        'type' => null,
        'title' => null,
        'name' => null,
        'path' => null,
        'icon' => null,
        'menu_type' => null,
        'url' => null,
        'component' => null,
        'keepalive' => null,
        'ps' => null,
        'sort' => null,
        'create_time' => null,
        'update_time' => null,
    ];

    protected array $extra = [];

    public function __construct(array $fields = [])
    {
        $this->setArray($fields);
    }

    public function toArray(bool $filtration = false): array
    {
        if (!$filtration){ return $this->fields; }
        return array_filter($this->fields,static function ($item){ return $item !== null;});
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

    public function setExtra(string $name, $value): self
    {
        $this->extra[$name] = $value;
        return $this;
    }

    public function getExtra(string|null $name = null, mixed $default = null): mixed
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

    public function __get(string $name): mixed
    {
        if (\array_key_exists($name, $this->fields)) {
           return $this->fields[$name];
        }
        return $this->extra[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        if (\array_key_exists($name, $this->fields)) {
           $this->fields[$name] = $value;
        } else {
           $this->extra[$name] = $value;
        }
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

    public function getPid(): mixed
    {
        return $this->fields['pid'];
    }

    /**
     * @param int $value 权限归属
     * @return self
     */
    public function setPid(int $value): self
    {
        $this->fields['pid'] = $value;
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

    public function getType(): mixed
    {
        return $this->fields['type'];
    }

    /**
     * @param int $value 类型:1=menu_dir=菜单目录,2=menu=菜单项,3=button=页面按钮
     * @return self
     */
    public function setType(int $value): self
    {
        $this->fields['type'] = $value;
        return $this;
    }

    public function getTitle(): mixed
    {
        return $this->fields['title'];
    }

    /**
     * @param mixed $value 规则标题
     * @return self
     */
    public function setTitle(mixed $value): self
    {
        $this->fields['title'] = $value;
        return $this;
    }

    public function getName(): mixed
    {
        return $this->fields['name'];
    }

    /**
     * @param mixed $value 规则名称(全英文小写)
     * @return self
     */
    public function setName(mixed $value): self
    {
        $this->fields['name'] = $value;
        return $this;
    }

    public function getPath(): mixed
    {
        return $this->fields['path'];
    }

    /**
     * @param mixed $value 路由路径
     * @return self
     */
    public function setPath(mixed $value): self
    {
        $this->fields['path'] = $value;
        return $this;
    }

    public function getIcon(): mixed
    {
        return $this->fields['icon'];
    }

    /**
     * @param mixed $value 图标
     * @return self
     */
    public function setIcon(mixed $value): self
    {
        $this->fields['icon'] = $value;
        return $this;
    }

    public function getMenuType(): mixed
    {
        return $this->fields['menu_type'];
    }

    /**
     * @param int $value 菜单类型:tab=选项卡,link=链接,iframe=Iframe
     * @return self
     */
    public function setMenuType(int $value): self
    {
        $this->fields['menu_type'] = $value;
        return $this;
    }

    public function getUrl(): mixed
    {
        return $this->fields['url'];
    }

    /**
     * @param mixed $value Url
     * @return self
     */
    public function setUrl(mixed $value): self
    {
        $this->fields['url'] = $value;
        return $this;
    }

    public function getComponent(): mixed
    {
        return $this->fields['component'];
    }

    /**
     * @param mixed $value vue组件路径
     * @return self
     */
    public function setComponent(mixed $value): self
    {
        $this->fields['component'] = $value;
        return $this;
    }

    public function getKeepalive(): mixed
    {
        return $this->fields['keepalive'];
    }

    /**
     * @param int $value 缓存:0=关闭,1=开启
     * @return self
     */
    public function setKeepalive(int $value): self
    {
        $this->fields['keepalive'] = $value;
        return $this;
    }

    public function getPs(): mixed
    {
        return $this->fields['ps'];
    }

    /**
     * @param mixed $value 备注
     * @return self
     */
    public function setPs(mixed $value): self
    {
        $this->fields['ps'] = $value;
        return $this;
    }

    public function getSort(): mixed
    {
        return $this->fields['sort'];
    }

    /**
     * @param int $value 排序
     * @return self
     */
    public function setSort(int $value): self
    {
        $this->fields['sort'] = $value;
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
