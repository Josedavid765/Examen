<?php

namespace Src\bc\Author\Domain\ValueObject;

use Src\shared\Domain\ValueObjects\DateValueObject;
use InvalidArgumentException;
use DateTimeImmutable;

class AuthorBirthDateValueObject extends DateValueObject
{
    public function __construct(?string $value = null)
    {
        parent::__construct($value);
        
        $this->ensureIsNotInFuture($this->value);
    }

    private function ensureIsNotInFuture(string $date): void
    {
        $birthDate = new DateTimeImmutable($date);
        $today = new DateTimeImmutable();

        if ($birthDate > $today) {
            throw new InvalidArgumentException(
                sprintf('<%s> no permite el valor <%s>. Un autor no puede nacer en el futuro.', static::class, $date)
            );
        }
    }
}

