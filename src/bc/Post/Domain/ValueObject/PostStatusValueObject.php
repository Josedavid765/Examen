<?php

namespace Src\bc\Post\Domain\ValueObject;

use InvalidArgumentException;
use Src\bc\Post\Domain\Enums\PostStatusEnum;


class PostStatusValueObject
{
    private PostStatusEnum $value;

    public function __construct(string $status)
    {
        $enum = PostStatusEnum::tryFrom(strtoupper($status));

        if (!$enum) {
            throw new InvalidArgumentException("El estado <$status> no es válido para un Post.");
        }

        $this->value = $enum;
    }

    public function value(): string { return $this->value->value; }

    public function isPublished(): bool { return $this->value === PostStatusEnum::PUBLISHED; }
    public function isDraft(): bool { return $this->value === PostStatusEnum::DRAFT; }
    public function isCancelled(): bool { return $this->value === PostStatusEnum::CANCELLED; }

    public function equals(PostStatusValueObject $other): bool { return $this->value === $other->value; }
    
    public function getEnum(): PostStatusEnum { return $this->value; }
}
