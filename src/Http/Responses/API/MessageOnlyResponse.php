<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Responses\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Thuraaung\APIUtils\Http\Responses\Status;

/**
 * A JSON Response Format for API Messages Only
 *
 * {
 *     "message": "Success",
 *     "status": 500,
 * }
 */
final class MessageOnlyResponse implements Responsable
{
    public function __construct(
        private string|null $message = 'Success.',
        private Status $status = Status::OK,
    ) {
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return \response()->json(
            data: [
                'message' => $this->message,
                'status' => $this->status->value,
            ],
            status: $this->status->value,
        );
    }
}
