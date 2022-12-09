<?php

namespace plugin\__kernel\abstracts;

/**
 * @Data: 2022/12/9
 * @Author: WasonCheung
 * @Description: 实体类基类
 */
abstract class BaseEntity
{
    /**
     * @var array 实体字段
     */
    protected array $fields = [];
    /**
     * @var array 临时的数据
     */
    protected array $extra = [];

    public function __construct(array $fields = [])
    {
        $this->setArray($fields);
    }

    public function setArray(array $fields): self
    {
        if (empty($fields)) {
            return $this;
        }
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

    public function __getExtra(string|null $name = null, mixed $default = null): mixed
    {
        if ($name === null) {
            return $this->extra;
        }
        return $this->extra[$name] ?? $default;
    }

    public function __setExtra(string $name, $value): self
    {
        $this->extra[$name] = $value;
        return $this;
    }

    public function __toString(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    public function toArray(bool $filtration = false): array
    {
        if (!$filtration) {
            return $this->fields;
        }
        return array_filter($this->fields, static function ($item) {
            return $item !== null;
        });
    }

    public function __serialize(): array
    {
        return $this->toArray(true);
    }

    public function __unserialize(array $fields): void
    {
        $this->setArray($fields);
    }
}
