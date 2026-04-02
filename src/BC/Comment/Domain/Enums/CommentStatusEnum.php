<?php

namespace Src\BC\Comment\Domain\Enums;

enum CommentStatusEnum: string
{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case CANCELLED = 'CANCELLED';
}
