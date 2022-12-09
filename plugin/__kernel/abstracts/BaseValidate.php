<?php

namespace plugin\__kernel\abstracts;

use plugin\__kernel\tools\RuleBuilder;
use think\Validate as ThinkValidate;

/**
 * @Data: 2022/11/24
 * @Author: WasonCheung
 * @Description: 自动解析验证器多语言
 */
abstract class BaseValidate extends ThinkValidate
{
    protected $failException = true;

    public function __construct()
    {
        parent::__construct();

        $ruleBuilder = $this->ruleBuilder();
        if ($ruleBuilder instanceof RuleBuilder) {
            $this->rule = array_merge($this->rule, $ruleBuilder->getRule());
        } else {
            $this->rule = array_merge($this->rule, $ruleBuilder);
        }
    }

    /**
     * @return array|RuleBuilder 验证规则构造
     * 验证规则构造
     */
    protected function ruleBuilder(): array|RuleBuilder
    {
        return [];
    }

    /**
     * @param array $data
     * @param array $rules
     * @return bool
     * 执行校验
     */
    public function check(array $data = [], array $rules = []): bool
    {
        return parent::check(array_merge($this->request->param(), $data), $rules);
    }

    /**
     * @param string $attribute
     * @param string $title
     * @param string $type
     * @param $rule
     * @return array|string
     * 重载获取规则提示信息
     */
    protected function getRuleMsg(string $attribute, string $title, string $type, $rule): array|string
    {
        $fieldPrefix = 'validate/field/';
        $ruleTypePrefix = 'validate/rule/';

        $ruleType = $ruleTypePrefix . $type;

        $attribute = $fieldPrefix . $attribute;
        $attribute = $this->lang->has($attribute) ? $this->lang->get($attribute) : $attribute;

        if ($this->lang->has($ruleType)) {
            $ruleType = $this->lang->get($ruleType);
            $args = explode(',', $rule);
            foreach ($args as $index => $arg) {
                if ($this->lang->has($fieldPrefix . $arg)) {
                    $args[$index] = $this->lang->get($fieldPrefix . $arg);
                }
            }
            return $this->lang->get($ruleType, array_merge([$attribute], $args));
        }
        return parent::getRuleMsg($attribute, $title, $type, $rule);
    }
}
