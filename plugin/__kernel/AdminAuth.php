<?php

namespace plugin\__kernel;

use plugin\__kernel\abstracts\SimpleRABC;
use think\App;

/**
 * @Data: 2022/12/9
 * @Author: WasonCheung
 * @Description: 管理认证类
 */
class AdminAuth extends SimpleRABC
{
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->rules = $this->initRules(
            $app->config->get('panda.admin_rule_table'),
            $app->config->get('panda.cache_time')
        );

        $this->roles = $this->initRoles(
            $app->config->get('panda.admin_role_table'),
            $app->config->get('panda.cache_time')
        );
    }

    public function hasRules(int $roleId, ...$rules): bool
    {
        // TODO: Implement hasRules() method.
    }

    public function getRoles(int $roleId = null): array
    {
        // TODO: Implement getRoles() method.
    }

    public function getRoleRules(int $roleId, ...$rules): array
    {
        // TODO: Implement getRoleRules() method.
    }

    public function getRules(int $ruleId = null): array
    {
        // TODO: Implement getRules() method.
    }

    public function addRulesForRole(int $roleId, ...$rules): void
    {
        // TODO: Implement addRulesForRole() method.
    }

    public function delRulesForRole(int $roleId, ...$rules): void
    {
        // TODO: Implement delRulesForRole() method.
    }

    public function addRoleForUser(int $userId, int $roleId): void
    {
        // TODO: Implement addRoleForUser() method.
    }
}
