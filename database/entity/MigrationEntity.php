<?php

declare(strict_types=1);

namespace database\entity;

/**
 * @property mixed $version
 * @property mixed $migration_name
 * @property mixed $start_time
 * @property mixed $end_time
 * @property mixed $breakpoint
 */
class MigrationEntity
{
    public const TABLE_NAME = 'panda_migrations';
    public const PRIMARY_KEY = 'version';
    public const VERSION = 'version';
    public const MIGRATION_NAME = 'migration_name';
    public const START_TIME = 'start_time';
    public const END_TIME = 'end_time';
    public const BREAKPOINT = 'breakpoint';

    protected array $fields = [
        'version' => null,
        'migration_name' => null,
        'start_time' => null,
        'end_time' => null,
        'breakpoint' => null,
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

    public function getVersion(): mixed
    {
        return $this->fields['version'];
    }

    /**
     * @param int $value
     * @return self
     */
    public function setVersion(int $value): self
    {
        $this->fields['version'] = $value;
        return $this;
    }

    public function getMigrationName(): mixed
    {
        return $this->fields['migration_name'];
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function setMigrationName(mixed $value): self
    {
        $this->fields['migration_name'] = $value;
        return $this;
    }

    public function getStartTime(): mixed
    {
        return $this->fields['start_time'];
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function setStartTime(mixed $value): self
    {
        $this->fields['start_time'] = $value;
        return $this;
    }

    public function getEndTime(): mixed
    {
        return $this->fields['end_time'];
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function setEndTime(mixed $value): self
    {
        $this->fields['end_time'] = $value;
        return $this;
    }

    public function getBreakpoint(): mixed
    {
        return $this->fields['breakpoint'];
    }

    /**
     * @param int $value
     * @return self
     */
    public function setBreakpoint(int $value): self
    {
        $this->fields['breakpoint'] = $value;
        return $this;
    }
}
