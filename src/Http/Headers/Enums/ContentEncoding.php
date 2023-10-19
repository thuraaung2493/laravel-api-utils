<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Headers\Enums;

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Encoding
 */
enum ContentEncoding: string
{
    case COMPRESS = 'compress';
    case DEFLATE = 'deflate';
    case GZIP = 'gzip';
}
