<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Headers;

use BackedEnum;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use Thuraaung\APIUtils\Http\Headers\Enums\ContentType;
use Thuraaung\APIUtils\Http\Headers\Enums\ContentEncoding;

/** @implements Arrayable<String, mixed> */
final class Headers implements Arrayable
{
    /**
     * @param Collection<string, mixed> $headers
     */
    public function __construct(
        private Collection $headers,
    ) {
    }

    public static function default(): self
    {
        return new Headers(
            Collection::make((array) config('api-utils.headers.defaults'))
        );
    }

    public static function of(): self
    {
        return new Headers(
            Collection::make([])
        );
    }

    public function accept(ContentType $type): self
    {
        $this->headers->put('Accept', $type);

        return $this;
    }

    public function acceptEncoding(ContentEncoding $encoding): self
    {
        $this->headers->put('Accept-Encoding', $encoding);

        return $this;
    }

    public function contentEncoding(ContentEncoding $encoding, bool $vapor = true): self
    {
        $this->headers->put('Content-Encoding', $encoding);

        if ($vapor) {
            $this->headers->put('X-Vapor-Base64-Encode', 'True');
        }

        return $this;
    }

    public function contentLength(int $length): self
    {
        $this->headers->put('Content-Length', $length);

        return $this;
    }

    public function contentType(ContentType $type): self
    {
        $this->headers->put('Content-Type', $type);

        return $this;
    }

    public function toArray()
    {
        return $this->headers->map(function (mixed $value) {
            if ($value instanceof BackedEnum) {
                return $value->value;
            }
            return $value;
        })->toArray();
    }
}
