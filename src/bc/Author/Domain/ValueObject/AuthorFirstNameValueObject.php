<?php

namespace Src\bc\Author\Domain\ValueObject;

use Src\shared\Domain\ValueObjects\StringValueObject;
use InvalidArgumentException;

class AuthorFirstNameValueObject extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);

        $this->ensureHasValidLength($value);
    }

    private function ensureHasValidLength(string $value): void
    {
        if (strlen(trim($value)) < 4) {
            throw new InvalidArgumentException(
                sprintf('<%s> no permite el valor <%s>. El nombre debe tener al menos 4 caracteres.', static::class, $value)
            );
        }
    }
}