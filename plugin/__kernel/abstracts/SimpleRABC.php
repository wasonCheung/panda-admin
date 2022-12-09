<?php

namespace plugin\__kernel\abstracts;

use plugin\__kernel\exception\AuthException;
use think\App;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * @Data: 2022/12/9
 * @Author: WasonCheung
 * @Description: 简易的基于角色的访问控制
 * 用户（1）=》角色（1）=》权限（多）
 */
abstract class SimpleRABC
{
    protected App $app;

    protected Db $db;

    /**
     * @var array 角色列表
     */
    protected array $roles = [];

    /**
     * @var array 权限规则列表
     */
    protected array $rules = [];

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->db = $app->db;
    }

    /**
     * @param int $roleId 角色id
     * @param ...$rules |权限规则
     * @return bool
     * @throws AuthException
     * @Data: 2022/12/9
     * @Author: WasonCheung
     * @Description:判断角色是由具有某些规则
     */
    public function hasRules(int $roleId, ...$rules): bool
    {
        // 角色信息
        $role = $this->getRoles($roleId);
        // 无限权限
        $roleRules = $role['rules'];

        if ($roleRules === '*') {
            return true;
        }

        if ($roleRules[]) {
            return false;
        }
    }

    /**
     * @param int|null $roleId null获取全部角色
     * @return array
     * @throws AuthException
     * @Data: 2022/12/9
     * @Author: WasonCheung
     * @Description: 获取角色
     */
    public function getRoles(int $roleId = null): array
    {
        // 获取所有角色组
        if ($roleId === null) {
            return $this->roles;
        }

        if (\array_key_exists($roleId, $this->roles)) {
            return $this->roles[$roleId];
        }

        // 角色组不存在
        throw new AuthException('plugin\__kernel\abstracts\SimpleRABC:role_not_found', $roleId);
    }

    /**
     * @param int $roleId
     * @param mixed ...$rules
     * @return array
     * @Data: 2022/12/9
     * @Author: WasonCheung
     * @Description: 获取角色权限
     */
    abstract public function getRoleRules(int $roleId, ...$rules): array;

    /**
     * @param mixed ...$ruleIds 不传参则获取全部
     * @return array
     * @Data: 2022/12/9
     * @Author: WasonCheung
     * @Description: 获取权限规则
     */
    public function getRules(...$ruleIds): array
    {
        if (empty($ruleIds)) {
            return $this->rules;
        }
        $result = [];
        foreach ($ruleIds as $ruleId) {
            if (\array_key_exists($ruleId, $this->rules)) {
                $rule = $this->rules[$ruleId];
                $result[$rule['name']] = $rule;
            }
        }
        return $result;
    }

    /**
     * @param int $roleId
     * @param ...$rules
     * @Data: 2022/12/9
     * @Author: WasonCheung
     * @Description: 给角色添加权限
     */
    abstract public function addRulesForRole(int $roleId, ...$rules): void;

    /**
     * @param int $roleId
     * @param ...$rules
     * @Data: 2022/12/9
     * @Author: WasonCheung
     * @Description: 删除角色的权限
     */
    abstract public function delRulesForRole(int $roleId, ...$rules): void;

    /**
     * @param int $userId
     * @param int $roleId
     * @Data: 2022/12/9
     * @Author: WasonCheung
     * @Description: 给用户设定角色
     */
    abstract public function addRoleForUser(int $userId, int $roleId): void;

    /**
     * @param string $roleTable
     * @param string $key
     * @param int $cacheTime
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @Data: 2022/12/9
     * @Author: WasonCheung
     * @Description: 初始化角色数据
     */
    protected function initRoles(string $roleTable, int $cacheTime = 3600, string $key = 'roles'): array
    {
        $data = $this->db
            ->table($roleTable)
            ->cache($key, $cacheTime)
            ->where('status', 1)
            ->select()
            ->toArray();

        $roles = [];
        foreach ($data as $role) {
            $roles[$role['id']] = $role;
        }
        return $roles;
    }

    /**
     * @param string $ruleTable
     * @param string $key
     * @param int $cacheTime
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @Data: 2022/12/9
     * @Author: WasonCheung
     * @Description: 初始化权限数据
     */
    protected function initRules(string $ruleTable, int $cacheTime = 3600, string $key = 'rules'): array
    {
        $data = $this->db
            ->table($ruleTable)
            ->cache($key, $cacheTime)
            ->where('status', 1)
            ->select()
            ->toArray();

        $rules = [];
        foreach ($data as $rule) {
            $rules[$rule['id']] = $rule;
        }
        return $rules;
    }
}
