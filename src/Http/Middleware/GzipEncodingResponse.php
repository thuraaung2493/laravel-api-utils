<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Thuraaung\APIUtils\Http\Headers\ContentEncoding;
use Thuraaung\APIUtils\Http\Headers\Headers;

use function Safe\gzencode;

class GzipEncodingResponse
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

        $isGzipEncoding = in_array(ContentEncoding::GZIP->value, $request->getEncodings());

        if ($isGzipEncoding && function_exists('gzencode')) {
            $response->setContent(
                content: gzencode(
                    data: strval($response->getContent()),
                    level: 9,
                ),
            );

            $response->headers->add(
                headers: Headers::of()
                    ->contentEncoding(ContentEncoding::GZIP)
                    ->toArray(),
            );
        }

        return $response;
    }
}
