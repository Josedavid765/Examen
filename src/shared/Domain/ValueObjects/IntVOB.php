<?php

namespace Src\shared\Domain\ValueObjects;

use InvalidArgumentException;

class IntVOB
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->ensureIsPositiveOrZero($value);
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    protected function ensureIsPositiveOrZero(int $value): void
    {
        if ($value < 0) {
            // Usamos static::class para que en el error salga el nombre de la clase hija (ej. "PostCommentCount")
            throw new InvalidArgumentException(
                sprintf('<%s> no permite el valor <%s>. Debe ser un número entero mayor o igual a 0.', static::class, $value)
            );
        }
    }
}
