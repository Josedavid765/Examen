<?php

namespace Src\shared\Domain\ValueObjects;

use Ramsey\Uuid\Uuid;
use InvalidArgumentException;

class UuidValueObject
{
    protected string $value;

    public function __construct(?string $value = null)
    {
        if($value === null){
            $this->value = Uuid::uuid4()->toString();
        }else{
            $this->ensureIsValidUuid($value);
            $this->value = $value;
        }
    }

    public function value(): string { return $this->value; }

    public function ensureIsValidUuid(string $id)
    {
        if(!Uuid::isValid($id)){
            throw new InvalidArgumentException(
                sprintf('<%s> no permite el valor <%s>. No es un UUID válido.', static::class, $id));
        }
    }

    public function __toString()
    {
        return $this->value;
    }
}
