<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http;

enum Scheme: string
{
    case HTTP = 'HTTP';
    case HTTPS = 'HTTPS';
}
