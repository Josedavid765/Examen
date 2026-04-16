<?php

namespace Src\BC\Author\Domain\ValueObject;
use Src\Shared\Domain\ValueObjects\StringValueObject;

class AuthorPasswordValueObject extends StringValueObject {
    public function __construct(string $value) {
        if (empty($value)) throw new \InvalidArgumentException("La contraseña no puede estar vacia");
        parent::__construct($value);
    }
}
