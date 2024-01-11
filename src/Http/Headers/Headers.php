<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Headers;

use BackedEnum;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<String, mixed> */
class Headers implements Arrayable
{
    /**
     * @param Collection<string, mixed> $headers
     */
    private function __construct(
        private Collection $headers,
    ) {
    }

    /**
     * Create default headers.
     */
    public static function default(): self
    {
        return new Headers(
            Collection::make((array) config('api-utils.headers.defaults'))
        );
    }

    /**
     * Create empty headers.
     */
    public static function of(): self
    {
        return new Headers(
            Collection::make([])
        );
    }

    /**
     * Create Accept header type.
     */
    public function accept(ContentType $type): self
    {
        $this->headers->put('Accept', $type);

        return $this;
    }

    /**
     * Create Accept-Encoding header type.
     */
    public function acceptEncoding(ContentEncoding $encoding): self
    {
        $this->headers->put('Accept-Encoding', $encoding);

        return $this;
    }

    /**
     * Create Content-Encoding header type.
     */
    public function contentEncoding(ContentEncoding $encoding, bool $vapor = true): self
    {
        $this->headers->put('Content-Encoding', $encoding);

        if ($vapor) {
            $this->headers->put('X-Vapor-Base64-Encode', 'True');
        }

        return $this;
    }

    /**
     * Create Content-Length header type.
     */
    public function contentLength(int $length): self
    {
        $this->headers->put('Content-Length', $length);

        return $this;
    }

    /**
     * Create Content-Type header type.
     */
    public function contentType(ContentType $type): self
    {
        $this->headers->put('Content-Type', $type);

        return $this;
    }

    /**
     * Check headers are empty.
     */
    public function isEmpty(): bool
    {
        return 0 === $this->headers->count();
    }

    /**
     * Return all headers.
     */
    public function toArray(): array
    {
        return $this->headers->map(function (mixed $value) {
            if ($value instanceof BackedEnum) {
                return $value->value;
            }
            return $value;
        })->toArray();
    }
}
