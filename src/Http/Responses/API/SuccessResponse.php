<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Responses\API;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
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
final class SuccessResponse implements Responsable
{
    public function __construct(
        private JsonResource|AnonymousResourceCollection|ResourceCollection $resource,
        private string|null $message = 'Success.',
        private Status $status = Status::OK,
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
        return $this->resource->additional([
            'message' => $this->message,
            'status' => $this->status->value,
        ])
            ->response()
            ->setStatusCode($this->status->value);
    }
}
