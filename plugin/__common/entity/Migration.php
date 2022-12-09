<?php

declare(strict_types=1);

namespace plugin\__common\entity;

class Migration extends \plugin\__kernel\abstracts\BaseEntity
{
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

    public function getVersion(): mixed
    {
        return $this->fields['version'];
    }

    public function setVersion(int $value): self
    {
        $this->fields['version'] = $value;
        return $this;
    }

    public function getMigrationName(): mixed
    {
        return $this->fields['migration_name'];
    }

    public function setMigrationName(mixed $value): self
    {
        $this->fields['migration_name'] = $value;
        return $this;
    }

    public function getStartTime(): mixed
    {
        return $this->fields['start_time'];
    }

    public function setStartTime(mixed $value): self
    {
        $this->fields['start_time'] = $value;
        return $this;
    }

    public function getEndTime(): mixed
    {
        return $this->fields['end_time'];
    }

    public function setEndTime(mixed $value): self
    {
        $this->fields['end_time'] = $value;
        return $this;
    }

    public function getBreakpoint(): mixed
    {
        return $this->fields['breakpoint'];
    }

    public function setBreakpoint(int $value): self
    {
        $this->fields['breakpoint'] = $value;
        return $this;
    }
}
