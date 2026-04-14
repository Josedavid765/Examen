<?php

namespace Src\BC\Comment\Domain\ValueObject;

use InvalidArgumentException;

use Src\Shared\Domain\ValueObjects\StringValueObject;

class CommentAuthorFullNameValueObject extends StringValueObject
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
                sprintf('<%s> no permite el valor <%s>. El nombre Completo debe tener al menos 3 caracteres.', static::class, $value)
            );
        }
    }
}
