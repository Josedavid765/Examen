<?php

namespace Src\BC\Author\Domain\ValueObject;
use Src\Shared\Domain\ValueObjects\StringValueObject;

class AuthorEmailValueObject extends StringValueObject {
    public function __construct(string $value) {
        if (empty($value)) throw new \InvalidArgumentException("El email no puede estar vacio");
        parent::__construct($value);
    }
}
