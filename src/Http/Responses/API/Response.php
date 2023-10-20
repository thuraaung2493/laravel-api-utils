<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Http\Responses\API;

use Illuminate\Contracts\Support\MessageBag;
use Thuraaung\APIUtils\Http\Responses\Status;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class Response
{
    private string $title = 'Failed!';

    private string|null $message;

    private Status|null $status;

    public static function of(): self
    {
        return new self();
    }

    /**
     *  Set title.
     */
    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     *  Set message.
     */
    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     *  Set status.
     */
    public function status(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Send a JSON Response for API Success.
     */
    public function sendSuccess(JsonResource|AnonymousResourceCollection|ResourceCollection $resource): SuccessResponse
    {
        return new SuccessResponse(
            resource: $resource,
            message: $this->message ?? 'Success.',
            status: $this->status ?? Status::OK,
        );
    }

    /**
     * Send A JSON Response for API Messages Only
     */
    public function sendMessage(string|null $message = null): MessageOnlyResponse
    {
        return new MessageOnlyResponse(
            message: $message ?? $this->message ?? 'Success.',
            status: $this->status ?? Status::OK,
        );
    }

    /**
     * Send a JSON Response for API Errors
     */
    public function sendFail(MessageBag|array $errors = []): FailResponse
    {
        return new FailResponse(
            title: $this->title,
            message: $this->message ?? 'Something went wrong!',
            errors: $errors,
            status: $this->status ?? Status::INTERNAL_SERVER_ERROR,
        );
    }
}
