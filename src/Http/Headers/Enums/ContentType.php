<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Headers\Enums;

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Type
 */
enum ContentType: string
{
    case JSON = 'application/json';
    case IMAGE = 'image/*';
}
