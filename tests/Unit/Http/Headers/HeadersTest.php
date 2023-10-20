<?php

declare(strict_types=1);

use Thuraaung\APIUtils\Http\Headers\Enums\ContentEncoding;
use Thuraaung\APIUtils\Http\Headers\Enums\ContentType;
use Thuraaung\APIUtils\Http\Headers\Headers;

describe('Headers', function () {
    test('of()', function (): void {
        expect(Headers::of())
            ->toBeInstanceOf(Headers::class)
            ->toHaveMethods([
                'accept',
                'acceptEncoding',
                'contentEncoding',
                'contentLength',
                'contentType',
                'toArray'
            ]);
    });

    test('default()', function (): void {
        expect(Headers::default())
            ->toBeInstanceOf(Headers::class)
            ->toHaveMethods([
                'accept',
                'acceptEncoding',
                'contentEncoding',
                'contentLength',
                'contentType',
                'toArray'
            ]);
    });

    test('accept()', function (): void {
        $headers = Headers::of()->accept(ContentType::JSON);

        expect($headers)
            ->toBeInstanceOf(Headers::class);

        expect($headers->toArray())
            ->toMatchArray([
                'Accept' => 'application/json',
            ]);
    });

    test('acceptEncoding()', function (): void {
        $headers = Headers::of()->acceptEncoding(ContentEncoding::GZIP);

        expect($headers)
            ->toBeInstanceOf(Headers::class);

        expect($headers->toArray())
            ->toMatchArray([
                'Accept-Encoding' => 'gzip',
            ]);
    });

    test('contentEncoding()', function (): void {
        $headers = Headers::of()->contentEncoding(ContentEncoding::GZIP);

        expect($headers)
            ->toBeInstanceOf(Headers::class);

        expect($headers->toArray())
            ->toMatchArray([
                'Content-Encoding' => 'gzip',
                'X-Vapor-Base64-Encode' => 'True'
            ]);
    });

    test('contentLength()', function (): void {
        $headers = Headers::of()->contentLength(216);

        expect($headers)
            ->toBeInstanceOf(Headers::class);

        expect($headers->toArray())
            ->toMatchArray([
                'Content-Length' => 216,
            ]);
    });

    test('contentType()', function (): void {
        $headers = Headers::of()->contentType(ContentType::JSON);

        expect($headers)
            ->toBeInstanceOf(Headers::class);

        expect($headers->toArray())
            ->toMatchArray([
                'Content-Type' => 'application/json',
            ]);
    });

    test('toArray()', function (): void {
        $headers = Headers::of()
            ->accept(ContentType::JSON)
            ->acceptEncoding(ContentEncoding::GZIP)
            ->contentEncoding(ContentEncoding::GZIP)
            ->contentLength(216)
            ->contentType(ContentType::JSON);

        expect($headers)
            ->toBeInstanceOf(Headers::class);

        expect($headers->toArray())
            ->toMatchArray([
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Encoding' => 'gzip',
                'X-Vapor-Base64-Encode' => 'True',
                'Content-Length' => 216,
                'Content-Type' => 'application/json',
            ]);
    });
});