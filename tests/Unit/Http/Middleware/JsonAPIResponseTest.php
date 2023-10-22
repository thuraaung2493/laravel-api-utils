<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Thuraaung\APIUtils\Http\Middleware\JsonAPIResponse;

it('returns the default headers', function (): void {
    $headers = new HeaderBag(
        headers: [
            'Content-Type' => 'application/json',
        ],
    );

    $response = (new JsonAPIResponse())->handle(
        request: createRequest('get', '/', $headers),
        next: fn () => new Response(),
    );

    foreach (\config('api-utils.headers.defaults') as $key => $value) {
        expect($response->headers->contains(
            key: str($key)->lower()->toString(),
            value: $value
        ))->toBeTrue();
    }
});

it('returns the json headers if default headers are not set', function (): void {
    $headers = new HeaderBag(
        headers: [
            'Content-Type' => 'application/json',
        ],
    );

    Config::set('api-utils.headers.defaults', []);

    $response = (new JsonAPIResponse())->handle(
        request: createRequest('get', '/', $headers),
        next: fn () => (new Response()),
    );

    expect($response->headers->contains('Accept', 'application/json'))
        ->toBeTrue();

    expect($response->headers->contains('Content-Type', 'application/json'))
        ->toBeTrue();
});


it('returns the image headers', function (): void {
    $headers = new HeaderBag(
        headers: [
            'Content-Type' => 'application/json',
        ],
    );

    $response = (new JsonAPIResponse())->handle(
        request: createRequest('get', '/', $headers),
        next: function () {
            $res = new Response();
            $res->headers->add(['Content-Type' => 'image/*']);
            return $res;
        },
    );

    expect($response->headers->contains('Accept', 'application/json'))
        ->toBeFalse();

    expect($response->headers->contains('Content-Type', 'application/json'))
        ->toBeFalse();
});
