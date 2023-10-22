<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Thuraaung\APIUtils\Http\Responses\Status;
use Thuraaung\APIUtils\Http\Responses\API\MessageOnlyResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

abstract class APIExceptionsHandler extends ExceptionHandler
{
    abstract protected function isJsonRequest(): bool;

    /**
     * Handle authentication exception. (Status - 401)
     */
    public function handleAuthenticationException(): self
    {
        $this->renderable(fn (AuthenticationException $e) => $this->toResponse($e, Status::UNAUTHORIZED));

        return $this;
    }

    /**
     * Handle access denied exception. (Status - 403)
     */
    public function handleAccessDeniedException(): self
    {
        $this->renderable(fn (AccessDeniedHttpException $e) => $this->toResponse($e, Status::FORBIDDEN));

        return $this;
    }

    /**
     * Handle not found exception. (Status - 404)
     */
    public function handleNotFoundException(): self
    {
        $this->renderable(fn (NotFoundHttpException $e) => $this->toResponse($e, Status::NOT_FOUND));

        return $this;
    }

    /**
     * Handle method not allow exception. (Status - 405)
     */
    public function handleMethodNotAllowException(): self
    {
        $this->renderable(fn (MethodNotAllowedHttpException $e) => $this->toResponse($e, Status::METHOD_NOT_ALLOWED));

        return $this;
    }

    /**
     * Handle not acceptable exception. (Status - 406)
     */
    public function handleNotAcceptableException(): self
    {
        $this->renderable(fn (NotAcceptableHttpException $e) => $this->toResponse($e, Status::NOT_ACCEPTABLE));

        return $this;
    }

    /**
     * Handle unprocessable entity exception. (Status - 422)
     */
    public function handleUnprocessableEntityException(): self
    {
        $this->renderable(fn (UnprocessableEntityHttpException $e) => $this->toResponse($e, Status::UNPROCESSABLE_CONTENT));

        return $this;
    }

    /**
     * Handle too many requests exception. (Status - 429)
     */
    public function handleTooManyRequestsException(): self
    {
        $this->renderable(fn (TooManyRequestsHttpException $e) => $this->toResponse($e, Status::TOO_MANY_REQUESTS));

        return $this;
    }

    /**
     * Handle merge custom exceptions.
     */
    public function handleMergeExceptions(array $callbacks): void
    {
        foreach ($callbacks as $callback) {
            $this->renderable($callback);
        }
    }

    /**
     * To response.
     *
     * @return \Illuminate\Contracts\Support\Responsable|void
     */
    protected function toResponse(Throwable $e, Status $status)
    {
        if ($this->isJsonRequest()) {
            return new MessageOnlyResponse(
                message: $e->getMessage(),
                status: $status,
            );
        }
    }
}
