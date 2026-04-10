<?php

namespace Src\BC\Author\Domain\ValueObject;

use Src\Shared\Domain\ValueObjects\StringValueObject;
use InvalidArgumentException;

class AuthorLastNameValueObject extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);

        $this->ensureHasValidLength($value);
    }

    private function ensureHasValidLength(string $value): void
    {
        if (mb_strlen(trim($value)) < 3) {
            throw new InvalidArgumentException(
                sprintf('<%s> no permite el valor <%s>. El nombre debe tener al menos 3 caracteres.', static::class, $value)
            );
        }
    }
}
