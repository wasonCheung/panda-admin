<?php

declare(strict_types=1);

namespace plugin\__common\entity;

class Rule extends \plugin\__kernel\abstracts\BaseEntity
{
    /** ID */
    public const PRIMARY_KEY = 'id';

    /** ID */
    public const ID = 'id';

    /** 权限归属 */
    public const PID = 'pid';

    /** 状态:0=禁用,1=启用 */
    public const STATUS = 'status';

    /** 类型:1=menu_dir=菜单目录,2=menu=菜单项,3=button=页面按钮 */
    public const TYPE = 'type';

    /** 规则标题 */
    public const TITLE = 'title';

    /** 规则名称(全英文小写) */
    public const NAME = 'name';

    /** 图标 */
    public const ICON = 'icon';

    /** 菜单类型:tab=选项卡,link=链接,iframe=Iframe */
    public const MENU_TYPE = 'menu_type';

    /** Url */
    public const URL = 'url';

    /** vue组件路径 */
    public const COMPONENT = 'component';

    /** 缓存:0=关闭,1=开启 */
    public const KEEPALIVE = 'keepalive';

    /** 备注 */
    public const PS = 'ps';

    /** 排序 */
    public const SORT = 'sort';

    /** 创建时间 */
    public const CREATE_TIME = 'create_time';

    /** 更新时间 */
    public const UPDATE_TIME = 'update_time';

    protected array $fields = [
        'id' => null,
        'pid' => null,
        'status' => null,
        'type' => null,
        'title' => null,
        'name' => null,
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

    public function getId(): mixed
    {
        return $this->fields['id'];
    }

    public function setId(int $value): self
    {
        $this->fields['id'] = $value;
        return $this;
    }

    public function getPid(): mixed
    {
        return $this->fields['pid'];
    }

    public function setPid(int $value): self
    {
        $this->fields['pid'] = $value;
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

    public function getType(): mixed
    {
        return $this->fields['type'];
    }

    public function setType(int $value): self
    {
        $this->fields['type'] = $value;
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

    public function getName(): mixed
    {
        return $this->fields['name'];
    }

    public function setName(mixed $value): self
    {
        $this->fields['name'] = $value;
        return $this;
    }

    public function getIcon(): mixed
    {
        return $this->fields['icon'];
    }

    public function setIcon(mixed $value): self
    {
        $this->fields['icon'] = $value;
        return $this;
    }

    public function getMenuType(): mixed
    {
        return $this->fields['menu_type'];
    }

    public function setMenuType(int $value): self
    {
        $this->fields['menu_type'] = $value;
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

    public function getComponent(): mixed
    {
        return $this->fields['component'];
    }

    public function setComponent(mixed $value): self
    {
        $this->fields['component'] = $value;
        return $this;
    }

    public function getKeepalive(): mixed
    {
        return $this->fields['keepalive'];
    }

    public function setKeepalive(int $value): self
    {
        $this->fields['keepalive'] = $value;
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

    public function getSort(): mixed
    {
        return $this->fields['sort'];
    }

    public function setSort(int $value): self
    {
        $this->fields['sort'] = $value;
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
