<?php

declare(strict_types=1);

namespace app\entity;

/**
 * @property mixed $id 主键
 * @property mixed $admin_group_id 管理组id
 * @property mixed $status 状态:0=禁用,1=启用
 * @property mixed $username 用户名
 * @property mixed $password 密码
 * @property mixed $nickname 昵称
 * @property mixed $avatar 头像
 * @property mixed $email 邮箱
 * @property mixed $login_failure 登录失败次数
 * @property mixed $last_login_time 最后登录时间
 * @property mixed $last_login_ip 最后登录ip
 * @property mixed $create_time 创建时间
 * @property mixed $update_time 更新时间
 */
class AdminEntity
{
    public const TABLE_NAME = 'panda_admin';
    public const PRIMARY_KEY = 'id';
    public const ID = 'id';
    public const ADMIN_GROUP_ID = 'admin_group_id';
    public const STATUS = 'status';
    public const USERNAME = 'username';
    public const PASSWORD = 'password';
    public const NICKNAME = 'nickname';
    public const AVATAR = 'avatar';
    public const EMAIL = 'email';
    public const LOGIN_FAILURE = 'login_failure';
    public const LAST_LOGIN_TIME = 'last_login_time';
    public const LAST_LOGIN_IP = 'last_login_ip';
    public const CREATE_TIME = 'create_time';
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
     * @param int $value 主键
     * @return self
     */
    public function setId(int $value): self
    {
        $this->fields['id'] = $value;
        return $this;
    }

    public function getAdminGroupId(): mixed
    {
        return $this->fields['admin_group_id'];
    }

    /**
     * @param int $value 管理组id
     * @return self
     */
    public function setAdminGroupId(int $value): self
    {
        $this->fields['admin_group_id'] = $value;
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

    public function getUsername(): mixed
    {
        return $this->fields['username'];
    }

    /**
     * @param mixed $value 用户名
     * @return self
     */
    public function setUsername(mixed $value): self
    {
        $this->fields['username'] = $value;
        return $this;
    }

    public function getPassword(): mixed
    {
        return $this->fields['password'];
    }

    /**
     * @param mixed $value 密码
     * @return self
     */
    public function setPassword(mixed $value): self
    {
        $this->fields['password'] = $value;
        return $this;
    }

    public function getNickname(): mixed
    {
        return $this->fields['nickname'];
    }

    /**
     * @param mixed $value 昵称
     * @return self
     */
    public function setNickname(mixed $value): self
    {
        $this->fields['nickname'] = $value;
        return $this;
    }

    public function getAvatar(): mixed
    {
        return $this->fields['avatar'];
    }

    /**
     * @param mixed $value 头像
     * @return self
     */
    public function setAvatar(mixed $value): self
    {
        $this->fields['avatar'] = $value;
        return $this;
    }

    public function getEmail(): mixed
    {
        return $this->fields['email'];
    }

    /**
     * @param mixed $value 邮箱
     * @return self
     */
    public function setEmail(mixed $value): self
    {
        $this->fields['email'] = $value;
        return $this;
    }

    public function getLoginFailure(): mixed
    {
        return $this->fields['login_failure'];
    }

    /**
     * @param int $value 登录失败次数
     * @return self
     */
    public function setLoginFailure(int $value): self
    {
        $this->fields['login_failure'] = $value;
        return $this;
    }

    public function getLastLoginTime(): mixed
    {
        return $this->fields['last_login_time'];
    }

    /**
     * @param int $value 最后登录时间
     * @return self
     */
    public function setLastLoginTime(int $value): self
    {
        $this->fields['last_login_time'] = $value;
        return $this;
    }

    public function getLastLoginIp(): mixed
    {
        return $this->fields['last_login_ip'];
    }

    /**
     * @param mixed $value 最后登录ip
     * @return self
     */
    public function setLastLoginIp(mixed $value): self
    {
        $this->fields['last_login_ip'] = $value;
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
