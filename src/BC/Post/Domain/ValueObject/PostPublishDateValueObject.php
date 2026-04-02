<?php

namespace Src\BC\Post\Domain\ValueObject;
use Src\Shared\Domain\ValueObjects\DateValueObject;
use InvalidArgumentException;
use DateTimeImmutable;

class PostPublishDateValueObject extends DateValueObject
{   
    public function __construct(?string $value = null)
    {
        parent::__construct($value);
        
        $this->ensureIsNotInFuture($this->value);
    }

    private function ensureIsNotInFuture(string $value): void
    {
        $date = new DateTimeImmutable($value);
        $now  = new DateTimeImmutable();

        if ($date > $now) {
            throw new InvalidArgumentException("La fecha de publicación de un post no puede ser en el futuro.");
        }
    }
}
