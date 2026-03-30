<?php

namespace Src\bc\Post\Domain\Enums;

enum PostStatusEnum: string
{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case CANCELLED = 'CANCELLED';
}
