<?php

namespace Src\BC\Post\Domain\ValueObject;

use Src\BC\Post\Domain\Enums\PostStatusEnum;
use InvalidArgumentException;


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
    public function getEnum(): PostStatusEnum { return $this->value; }

    public function isPublished(): bool { return $this->value === PostStatusEnum::PUBLISHED; }
    public function isDraft(): bool { return $this->value === PostStatusEnum::DRAFT; }
    public function isCancelled(): bool { return $this->value === PostStatusEnum::CANCELLED; }

    public function equals(PostStatusValueObject $other): bool { return $this->value === $other->value; }
}
