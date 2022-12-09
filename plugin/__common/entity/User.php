<?php

declare(strict_types=1);

namespace plugin\__common\entity;

class User extends \plugin\__kernel\abstracts\BaseEntity
{
    /** ID */
    public const PRIMARY_KEY = 'id';

    /** ID */
    public const ID = 'id';

    /** 用户组id */
    public const USER_GROUP_ID = 'user_group_id';

    /** 用户组到期时间 */
    public const USER_GROUP_END_TIME = 'user_group_end_time';

    /** 用户状态：0=未审核,1=正常,2=被禁用 */
    public const STATUS = 'status';

    /** 用户名 */
    public const USERNAME = 'username';

    /** 密码 */
    public const PASSWORD = 'password';

    /** 昵称 */
    public const NICKNAME = 'nickname';

    /** 邮箱地址 */
    public const EMAIL = 'email';

    /** 头像 */
    public const AVATAR = 'avatar';

    /** 安全问题 */
    public const QUESTION = 'question';

    /** 安全答案 */
    public const ANSWER = 'answer';

    /** 关于我 */
    public const ABOUT_ME = 'about_me';

    /** 性别:1=男,2=女,0=人妖 */
    public const GENDER = 'gender';

    /** 生日 */
    public const BIRTHDAY = 'birthday';

    /** 金币 */
    public const COINS = 'coins';

    /** 登录次数 */
    public const LOGIN_NUM = 'login_num';

    /** 上次登录时间 */
    public const LAST_LOGIN_TIME = 'last_login_time';

    /** 上次登录IP */
    public const LAST_LOGIN_IP = 'last_login_ip';

    /** 登录失败次数 */
    public const LOGIN_FAILURE = 'login_failure';

    /** 创建时间 */
    public const CREATE_TIME = 'create_time';

    /** 更新时间 */
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

    public function getId(): mixed
    {
        return $this->fields['id'];
    }

    public function setId(int $value): self
    {
        $this->fields['id'] = $value;
        return $this;
    }

    public function getUserGroupId(): mixed
    {
        return $this->fields['user_group_id'];
    }

    public function setUserGroupId(int $value): self
    {
        $this->fields['user_group_id'] = $value;
        return $this;
    }

    public function getUserGroupEndTime(): mixed
    {
        return $this->fields['user_group_end_time'];
    }

    public function setUserGroupEndTime(int $value): self
    {
        $this->fields['user_group_end_time'] = $value;
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

    public function getEmail(): mixed
    {
        return $this->fields['email'];
    }

    public function setEmail(mixed $value): self
    {
        $this->fields['email'] = $value;
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

    public function getQuestion(): mixed
    {
        return $this->fields['question'];
    }

    public function setQuestion(mixed $value): self
    {
        $this->fields['question'] = $value;
        return $this;
    }

    public function getAnswer(): mixed
    {
        return $this->fields['answer'];
    }

    public function setAnswer(mixed $value): self
    {
        $this->fields['answer'] = $value;
        return $this;
    }

    public function getAboutMe(): mixed
    {
        return $this->fields['about_me'];
    }

    public function setAboutMe(mixed $value): self
    {
        $this->fields['about_me'] = $value;
        return $this;
    }

    public function getGender(): mixed
    {
        return $this->fields['gender'];
    }

    public function setGender(int $value): self
    {
        $this->fields['gender'] = $value;
        return $this;
    }

    public function getBirthday(): mixed
    {
        return $this->fields['birthday'];
    }

    public function setBirthday(int $value): self
    {
        $this->fields['birthday'] = $value;
        return $this;
    }

    public function getCoins(): mixed
    {
        return $this->fields['coins'];
    }

    public function setCoins(int $value): self
    {
        $this->fields['coins'] = $value;
        return $this;
    }

    public function getLoginNum(): mixed
    {
        return $this->fields['login_num'];
    }

    public function setLoginNum(int $value): self
    {
        $this->fields['login_num'] = $value;
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

    public function getLoginFailure(): mixed
    {
        return $this->fields['login_failure'];
    }

    public function setLoginFailure(int $value): self
    {
        $this->fields['login_failure'] = $value;
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
