<?php

namespace plugin\__panda;

use think\exception\InvalidArgumentException;

/**
 *
 * ----------------------------------------------------------------
 *
 * @method RuleBuilder confirm(...$args)  验证是否和某个字段的值一致
 * @method RuleBuilder different(...$args) 验证是否和某个字段的值是否不同
 * @method RuleBuilder egt(...$args) 验证是否大于等于某个值
 * @method RuleBuilder gt(...$args) 验证是否大于某个值
 * @method RuleBuilder elt(...$args) 验证是否小于等于某个值
 * @method RuleBuilder lt(...$args) 验证是否小于某个值
 * @method RuleBuilder eq(...$args) 验证是否等于某个值
 * @method RuleBuilder in(...$args) 验证是否在范围内
 * @method RuleBuilder notIn(...$args) 验证是否不在某个范围
 * @method RuleBuilder between(...$args) 验证是否在某个区间
 * @method RuleBuilder notBetween(...$args) 验证是否不在某个区间
 * @method RuleBuilder length(...$args) 验证数据长度
 * @method RuleBuilder max(...$args) 验证数据最大长度
 * @method RuleBuilder min(...$args) 验证数据最小长度
 * @method RuleBuilder after(...$args) 验证日期
 * @method RuleBuilder before(...$args) 验证日期
 * @method RuleBuilder expire(...$args) 验证有效期
 * @method RuleBuilder allowIp(...$args) 验证IP许可
 * @method RuleBuilder denyIp(...$args) 验证IP禁用
 * @method RuleBuilder regex(...$args) 使用正则验证数据
 * @method RuleBuilder is(...$args) 验证字段值是否为有效格式
 * @method RuleBuilder require (...$args) 验证字段必须
 * @method RuleBuilder number(...$args) 验证字段值是否为数字
 * @method RuleBuilder array(...$args) 验证字段值是否为数组
 * @method RuleBuilder integer(...$args) 验证字段值是否为整形
 * @method RuleBuilder float(...$args) 验证字段值是否为浮点数
 * @method RuleBuilder mobile(...$args) 验证字段值是否为手机
 * @method RuleBuilder idCard(...$args) 验证字段值是否为身份证号码
 * @method RuleBuilder chs(...$args) 验证字段值是否为中文
 * @method RuleBuilder chsDash(...$args) 验证字段值是否为中文字母及下划线
 * @method RuleBuilder chsAlpha(...$args) 验证字段值是否为中文和字母
 * @method RuleBuilder chsAlphaNum(...$args) 验证字段值是否为中文字母和数字
 * @method RuleBuilder date(...$args) 验证字段值是否为有效格式
 * @method RuleBuilder bool(...$args) 验证字段值是否为布尔值
 * @method RuleBuilder alpha(...$args) 验证字段值是否为字母
 * @method RuleBuilder alphaDash(...$args) 验证字段值是否为字母和下划线
 * @method RuleBuilder alphaNum(...$args) 验证字段值是否为字母和数字
 * @method RuleBuilder accepted(...$args) 验证字段值是否为yes, on, 或是 1
 * @method RuleBuilder email(...$args) 验证字段值是否为有效邮箱格式
 * @method RuleBuilder url(...$args) 验证字段值是否为有效URL地址
 * @method RuleBuilder activeUrl(...$args) 验证是否为合格的域名或者IP
 * @method RuleBuilder ip(...$args) 验证是否有效IP
 * @method RuleBuilder fileExt(...$args) 验证文件后缀
 * @method RuleBuilder fileMime(...$args) 验证文件类型
 * @method RuleBuilder fileSize(...$args) 验证文件大小
 * @method RuleBuilder image(...$args) 验证图像文件
 * @method RuleBuilder method(...$args) 验证请求类型
 * @method RuleBuilder dateFormat(...$args) 验证时间和日期是否符合指定格式
 * @method RuleBuilder unique(...$args) 验证是否唯一
 * @method RuleBuilder behavior(...$args) 使用行为类验证
 * @method RuleBuilder filter(...$args) 使用filter_var方式验证
 * @method RuleBuilder requireIf(...$args) 验证某个字段等于某个值的时候必须
 * @method RuleBuilder requireCallback(...$args) 通过回调方法验证某个字段是否必须
 * @method RuleBuilder requireWith(...$args) 验证某个字段有值的情况下必须
 * @method RuleBuilder must(...$args) 必须验证
 */
class RuleBuilder
{
    protected static ?RuleBuilder $instance = null;
    protected array $rule = [];
    protected string $field = '';

    protected function __construct()
    {
    }

    public static function builder(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $name 额外的规则名
     * @param ...$args
     * @return $this
     * 添加额外的规则
     */
    public function extra(string $name, ...$args): self
    {
        $this->__call($name, $args);
        return $this;
    }

    public function __call($method, $args)
    {
        $this->checkFieldExists();

        $name = $method;

        if ($args) {
            $name .= ':';
            $name .= implode(',', $args);
        }

        $this->rule[$this->field][] = $name;

        return $this;
    }

    private function checkFieldExists(): void
    {
        if (!isset($this->field)) {
            throw new InvalidArgumentException('RuleBuilder: field 没有设置');
        }
    }

    /**
     * @return $this
     * 添加验证码规则
     */
    public function captcha(bool $captcha = false): self
    {
        if ($captcha) {
            $this->rule['captcha'] = 'require|captcha';
        }
        return $this;
    }

    /**
     * @param bool $token
     * @return $this
     * token字段
     */
    public function token(bool $token = false): self
    {
        if ($token) {
            $this->rule['__token__'] = 'require|token';
        }
        return $this;
    }

    /**
     * @param string $field 规则字段名
     * @return $this
     * 设置当前规则 字段名
     */
    public function rule(string $field): self
    {
        $this->field = $field;
        return $this;
    }

    /**
     * 构建一条规则
     */
    public function build(): self
    {
        $this->rule[$this->field] = implode('|', $this->rule[$this->field]);
        $this->field = '';
        return $this;
    }

    public function getRule(): array
    {
        return $this->rule;
    }
}
