<?php

declare(strict_types=1);

namespace database\entity;

/**
 * @property mixed $id ID
 * @property mixed $user_group_id 用户组id
 * @property mixed $user_group_end_time 用户组到期时间
 * @property mixed $status 用户状态：0=未审核,1=正常,2=被禁用
 * @property mixed $username 用户名
 * @property mixed $password 密码
 * @property mixed $nickname 昵称
 * @property mixed $email 邮箱地址
 * @property mixed $avatar 头像
 * @property mixed $question 安全问题
 * @property mixed $answer 安全答案
 * @property mixed $about_me 关于我
 * @property mixed $gender 性别:1=男,2=女,0=人妖
 * @property mixed $birthday 生日
 * @property mixed $coins 金币
 * @property mixed $login_num 登录次数
 * @property mixed $last_login_time 上次登录时间
 * @property mixed $last_login_ip 上次登录IP
 * @property mixed $login_failure 登录失败次数
 * @property mixed $create_time 创建时间
 * @property mixed $update_time 更新时间
 */
class UserEntity
{
    public const TABLE_NAME = 'panda_user';
    public const PRIMARY_KEY = 'id';
    public const ID = 'id';
    public const USER_GROUP_ID = 'user_group_id';
    public const USER_GROUP_END_TIME = 'user_group_end_time';
    public const STATUS = 'status';
    public const USERNAME = 'username';
    public const PASSWORD = 'password';
    public const NICKNAME = 'nickname';
    public const EMAIL = 'email';
    public const AVATAR = 'avatar';
    public const QUESTION = 'question';
    public const ANSWER = 'answer';
    public const ABOUT_ME = 'about_me';
    public const GENDER = 'gender';
    public const BIRTHDAY = 'birthday';
    public const COINS = 'coins';
    public const LOGIN_NUM = 'login_num';
    public const LAST_LOGIN_TIME = 'last_login_time';
    public const LAST_LOGIN_IP = 'last_login_ip';
    public const LOGIN_FAILURE = 'login_failure';
    public const CREATE_TIME = 'create_time';
    public const UPDATE_TIME = 'update_time';

    protected array $fields = [
        'id' => null,
        'user_group_id' => null,
        'user_group_end_time' => null,
        'status' => null,
        'username' => null,
        'password' => null,
        'nickname' => null,
        'email' => null,
        'avatar' => null,
        'question' => null,
        'answer' => null,
        'about_me' => null,
        'gender' => null,
        'birthday' => null,
        'coins' => null,
        'login_num' => null,
        'last_login_time' => null,
        'last_login_ip' => null,
        'login_failure' => null,
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

    public function getUserGroupId(): mixed
    {
        return $this->fields['user_group_id'];
    }

    /**
     * @param int $value 用户组id
     * @return self
     */
    public function setUserGroupId(int $value): self
    {
        $this->fields['user_group_id'] = $value;
        return $this;
    }

    public function getUserGroupEndTime(): mixed
    {
        return $this->fields['user_group_end_time'];
    }

    /**
     * @param int $value 用户组到期时间
     * @return self
     */
    public function setUserGroupEndTime(int $value): self
    {
        $this->fields['user_group_end_time'] = $value;
        return $this;
    }

    public function getStatus(): mixed
    {
        return $this->fields['status'];
    }

    /**
     * @param int $value 用户状态：0=未审核,1=正常,2=被禁用
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

    public function getEmail(): mixed
    {
        return $this->fields['email'];
    }

    /**
     * @param mixed $value 邮箱地址
     * @return self
     */
    public function setEmail(mixed $value): self
    {
        $this->fields['email'] = $value;
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

    public function getQuestion(): mixed
    {
        return $this->fields['question'];
    }

    /**
     * @param mixed $value 安全问题
     * @return self
     */
    public function setQuestion(mixed $value): self
    {
        $this->fields['question'] = $value;
        return $this;
    }

    public function getAnswer(): mixed
    {
        return $this->fields['answer'];
    }

    /**
     * @param mixed $value 安全答案
     * @return self
     */
    public function setAnswer(mixed $value): self
    {
        $this->fields['answer'] = $value;
        return $this;
    }

    public function getAboutMe(): mixed
    {
        return $this->fields['about_me'];
    }

    /**
     * @param mixed $value 关于我
     * @return self
     */
    public function setAboutMe(mixed $value): self
    {
        $this->fields['about_me'] = $value;
        return $this;
    }

    public function getGender(): mixed
    {
        return $this->fields['gender'];
    }

    /**
     * @param int $value 性别:1=男,2=女,0=人妖
     * @return self
     */
    public function setGender(int $value): self
    {
        $this->fields['gender'] = $value;
        return $this;
    }

    public function getBirthday(): mixed
    {
        return $this->fields['birthday'];
    }

    /**
     * @param int $value 生日
     * @return self
     */
    public function setBirthday(int $value): self
    {
        $this->fields['birthday'] = $value;
        return $this;
    }

    public function getCoins(): mixed
    {
        return $this->fields['coins'];
    }

    /**
     * @param int $value 金币
     * @return self
     */
    public function setCoins(int $value): self
    {
        $this->fields['coins'] = $value;
        return $this;
    }

    public function getLoginNum(): mixed
    {
        return $this->fields['login_num'];
    }

    /**
     * @param int $value 登录次数
     * @return self
     */
    public function setLoginNum(int $value): self
    {
        $this->fields['login_num'] = $value;
        return $this;
    }

    public function getLastLoginTime(): mixed
    {
        return $this->fields['last_login_time'];
    }

    /**
     * @param int $value 上次登录时间
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
     * @param mixed $value 上次登录IP
     * @return self
     */
    public function setLastLoginIp(mixed $value): self
    {
        $this->fields['last_login_ip'] = $value;
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
