<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Thuraaung\APIUtils\Tests\TestCase;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

uses(TestCase::class)->in(__DIR__);

function createRequest(string $method, string $uri, HeaderBag $headers): Request
{
    $symfonyRequest = SymfonyRequest::create(
        uri: $uri,
        method: $method,
    );

    $symfonyRequest->headers = $headers;

    return Request::createFromBase($symfonyRequest);
}
