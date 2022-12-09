<?php

declare(strict_types=1);

namespace plugin\__common\entity;

class Admin extends \plugin\__kernel\abstracts\BaseEntity
{
    /** 主键 */
    public const PRIMARY_KEY = 'id';

    /** 主键 */
    public const ID = 'id';

    /** 管理组id */
    public const ADMIN_GROUP_ID = 'admin_group_id';

    /** 状态:0=禁用,1=启用 */
    public const STATUS = 'status';

    /** 用户名 */
    public const USERNAME = 'username';

    /** 密码 */
    public const PASSWORD = 'password';

    /** 昵称 */
    public const NICKNAME = 'nickname';

    /** 头像 */
    public const AVATAR = 'avatar';

    /** 邮箱 */
    public const EMAIL = 'email';

    /** 登录失败次数 */
    public const LOGIN_FAILURE = 'login_failure';

    /** 最后登录时间 */
    public const LAST_LOGIN_TIME = 'last_login_time';

    /** 最后登录ip */
    public const LAST_LOGIN_IP = 'last_login_ip';

    /** 创建时间 */
    public const CREATE_TIME = 'create_time';

    /** 更新时间 */
    public const UPDATE_TIME = 'update_time';

    protected array $fields = [
        'id' => null,
        'admin_group_id' => null,
        'status' => null,
        'username' => null,
        'password' => null,
        'nickname' => null,
        'avatar' => null,
        'email' => null,
        'login_failure' => null,
        'last_login_time' => null,
        'last_login_ip' => null,
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

    public function getAdminGroupId(): mixed
    {
        return $this->fields['admin_group_id'];
    }

    public function setAdminGroupId(int $value): self
    {
        $this->fields['admin_group_id'] = $value;
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

    public function getUsername(): mixed
    {
        return $this->fields['username'];
    }

    public function setUsername(mixed $value): self
    {
        $this->fields['username'] = $value;
        return $this;
    }

    public function getPassword(): mixed
    {
        return $this->fields['password'];
    }

    public function setPassword(mixed $value): self
    {
        $this->fields['password'] = $value;
        return $this;
    }

    public function getNickname(): mixed
    {
        return $this->fields['nickname'];
    }

    public function setNickname(mixed $value): self
    {
        $this->fields['nickname'] = $value;
        return $this;
    }

    public function getAvatar(): mixed
    {
        return $this->fields['avatar'];
    }

    public function setAvatar(mixed $value): self
    {
        $this->fields['avatar'] = $value;
        return $this;
    }

    public function getEmail(): mixed
    {
        return $this->fields['email'];
    }

    public function setEmail(mixed $value): self
    {
        $this->fields['email'] = $value;
        return $this;
    }

    public function getLoginFailure(): mixed
    {
        return $this->fields['login_failure'];
    }

    public function setLoginFailure(int $value): self
    {
        $this->fields['login_failure'] = $value;
        return $this;
    }

    public function getLastLoginTime(): mixed
    {
        return $this->fields['last_login_time'];
    }

    public function setLastLoginTime(int $value): self
    {
        $this->fields['last_login_time'] = $value;
        return $this;
    }

    public function getLastLoginIp(): mixed
    {
        return $this->fields['last_login_ip'];
    }

    public function setLastLoginIp(mixed $value): self
    {
        $this->fields['last_login_ip'] = $value;
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
