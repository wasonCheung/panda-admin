<?php declare (strict_types = 1);

namespace generator\entity;

class Column extends Entity
{

	protected string $Field;

	protected string $Type;

	protected string $Null;

	protected ?string $Key;

	protected string|int|null $Default;

	protected ?string $Extra;

	protected ?string $Comment;


    public function getComment(): ?string
    {
        return $this->Comment;
    }



	public function getField(): string
	{
		return $this->Field;
	}

	public function getType(): string
	{
		return $this->Type;
	}

	public function isNullable(): bool
	{
		return $this->Null === 'YES';
	}

	public function getKey(): ?string
	{
		return $this->Key;
	}

	public function getDefault(): string|int|null
	{
		return $this->Default;
	}

	public function getExtra(): ?string
	{
		return $this->Extra;
	}

	public function isPrimary(): bool
	{
		return $this->Key === 'PRI';
	}

}
