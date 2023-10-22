<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Thuraaung\APIUtils\Http\Responses\API\MessageOnlyResponse;
use Thuraaung\APIUtils\Http\Responses\Status;

trait HasRender
{
    public static function of(string $message, Status $status): self
    {
        return new self($message, $status->value);
    }

    public function render(Request $request): Response|bool
    {
        if ($request->isJson()) {
            (new MessageOnlyResponse(
                message: $this->message,
                status: $this->status,
            ))->toResponse($request);
        }

        return false;
    }
}
