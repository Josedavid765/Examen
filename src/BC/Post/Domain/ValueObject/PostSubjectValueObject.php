<?php

namespace Src\BC\Post\Domain\ValueObject;

use Src\Shared\Domain\ValueObjects\StringValueObject;
use InvalidArgumentException;

class PostSubjectValueObject extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);

        $this->ensureHasValidLength($value);
    }

    private function ensureHasValidLength(string $value): void
    {
        if (mb_strlen(trim($value)) < 1) {
            throw new InvalidArgumentException(
                sprintf('<%s> no permite el valor <%s>. El titulo del post debe tener al menos 1 caracteres.', static::class, $value)
            );
        }
    }
}
