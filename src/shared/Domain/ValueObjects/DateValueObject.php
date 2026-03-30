<?php

namespace Src\shared\Domain\ValueObjects;

use InvalidArgumentException;
use DateTimeImmutable;
use Exception;

class DateValueObject
{
    protected string $value;

    public function __construct(?string $value = null)
    {
        if ($value == null) {
            $this->value = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        } else {
            $this->ensureIsValidDate($value);
            $this->value = (new DateTimeImmutable($value))->format('Y-m-d H:i:s'); 
        }
    }

    public function value(): string 
    { 
        return $this->value; 
    }

    protected function ensureIsValidDate(string $date): void
    {
        try {
            new DateTimeImmutable($date);
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf('<%s> no permite el valor <%s>. No es una fecha válida.', static::class, $date)
            );
        }
    }
}