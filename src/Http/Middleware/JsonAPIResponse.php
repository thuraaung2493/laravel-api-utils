<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Thuraaung\APIUtils\Http\Headers\Enums\ContentType;
use Thuraaung\APIUtils\Http\Headers\Headers;

use function explode;

final class JsonAPIResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response */
        $response = $next($request);

        $headers = Headers::default()->toArray();

        if (\count($headers) === 0) {
            $headers = Headers::of()
                ->accept(ContentType::JSON)
                ->contentType(ContentType::JSON);
        }

        if ($request->isJson() && !$this->isImageContentType($response)) {
            $response->headers->add(
                headers: $headers,
            );
        }

        return $response;
    }

    private function isImageContentType(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type');

        if (null === $contentType) {
            return false;
        }

        return Str::contains(
            haystack: 'image',
            needles: explode(
                separator: '/',
                string: $contentType
            ),
        );
    }
}
