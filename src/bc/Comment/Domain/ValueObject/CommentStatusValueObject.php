<?php

namespace Src\bc\Comment\Domain\ValueObject;

use Src\bc\Comment\Domain\Enums\CommentStatusEnum;
use InvalidArgumentException;

class CommentStatusValueObject
{
    private CommentStatusEnum $value;

    public function __construct(string $status)
    {
        $enum = CommentStatusEnum::tryFrom(strtoupper($status));

        if (!$enum) {
            throw new InvalidArgumentException("El estado <$status> no es válido para un comment.");
        }

        $this->value = $enum;
    }

    public function value(): string { return $this->value->value; }

    public function isPublished(): bool { return $this->value === CommentStatusEnum::PUBLISHED; }
    public function isDraft(): bool { return $this->value === CommentStatusEnum::DRAFT; }
    public function isCancelled(): bool { return $this->value === CommentStatusEnum::CANCELLED; }

    public function equals(CommentStatusValueObject $other): bool { return $this->value === $other->value; }
    
    public function getEnum(): CommentStatusEnum { return $this->value; }
}
