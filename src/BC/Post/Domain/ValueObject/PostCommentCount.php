<?php

namespace Src\BC\Post\Domain\ValueObject;

use InvalidArgumentException;
use Src\Shared\Domain\ValueObjects\IntValueObject;

class PostCommentCount extends IntValueObject
{
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException("El número de comentarios no puede ser negativo.");
        }

        parent::__construct($value);
    }

    
    public function increment(): self
    {
        return new self($this->value() + 1);
    }

    public function decrement(): self
    {
        if ($this->value() <= 0) {
            return new self(0);
        }

        return new self($this->value() - 1);
    }
}
