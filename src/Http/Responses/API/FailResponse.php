<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Responses\API;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Thuraaung\APIUtils\Http\Responses\Status;

/**
 * A JSON Response Format for API Errors
 *
 * {
 *     "title": "Failed!",
 *     "message": "Something went wrong!",
 *     "errors": [],
 *     "status": 500,
 * }
 */
final class FailResponse implements Responsable
{
    public function __construct(
        private string|null $title = 'Failed!',
        private string|null $message = 'Something went wrong!',
        private MessageBag|array $errors = [],
        private Status $status = Status::INTERNAL_SERVER_ERROR,
    ) {
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request): JsonResponse
    {
        return \response()->json(
            data: [
                'title' => $this->title,
                'message' => $this->message,
                'errors' => $this->errors,
                'status' => $this->status->value,
            ],
            status: $this->status->value,
        );
    }
}
