<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Thuraaung\APIUtils\Http\Middleware\GzipEncodingResponse;

use function Safe\gzdecode;

it('can handle the content encoding', function (): void {
    $headers = new HeaderBag(
        headers: ['Accept-Encoding' => 'gzip'],
    );

    $response = (new GzipEncodingResponse())->handle(
        request: createRequest('get', '/', $headers),
        next: fn () => (new Response())->setContent('Hello'),
    );

    expect($response->headers->get('Content-Encoding'))->toBe('gzip');
    expect($response->headers->get('x-vapor-base64-encode'))->toBe('True');
    expect(gzdecode($response->getContent()))->toBe('Hello');
});
