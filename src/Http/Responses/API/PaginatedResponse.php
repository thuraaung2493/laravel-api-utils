<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Responses\API;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Thuraaung\APIUtils\Http\Responses\Status;

/**
 * API Success JSON Response Format.
 *
 * {
 *     "data": "object" or [],
 *     "message": "Success.",
 *     "status": 200,
 * }
 */
class PaginatedResponse implements Responsable
{
    public function __construct(
        private AnonymousResourceCollection|ResourceCollection $resource,
        private string|null $message = 'Success.',
        private Status $status = Status::OK,
    ) {
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return (new PaginatedResourceResponse(
            resource: $this->resource->additional([
                'message' => $this->message,
                'status' => $this->status->value,
            ]),
        ))
            ->toResponse($request)
            ->setStatusCode($this->status->value);
    }
}
