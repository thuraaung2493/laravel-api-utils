# Laravel API Utils

**It supports _Laravel 9+_ and _PHP 8.2_+**

-   [Laravel API Utils](#laravel-api-utils)
    -   [Description](#description)
    -   [Installation](#installation)
    -   [Publish the config file](#publish-the-config-file)
    -   [Usage](#usage)
        -   [Responses](#responses)
            -   [API Success JSON Response Format.](#api-success-json-response-format)
            -   [API Paginated JSON Response Format.](#api-paginated-json-response-format)
            -   [A JSON Response Format for API Errors.](#a-json-response-format-for-api-errors)
            -   [A JSON Response Format for API Messages Only](#a-json-response-format-for-api-messages-only)
        -   [Enums](#enums)
        -   [Headers](#headers)
        -   [Middleware Classes](#middleware-classes)
        -   [Exceptions](#exceptions)

## Description

This package contains many utility APIs that assist in API creation.

## Installation

Require this package with composer using the following command:

```bash
composer require thuraaung2493/laravel-api-utils
```

## Publish the config file

```bash
php artisan vendor:publish --provider="Thuraaung\APIUtils\LaravelAPIUtilsServiceProvider" --tag="api-utils"
```

## Usage

### Responses

**All API Response classes implement the Responsable interface.**

| Class                                                            | Description                                |
| ---------------------------------------------------------------- | ------------------------------------------ |
| Thuraaung\APIUtils\Http\Responses\API\SuccessResponse::class     | It returns json response for success.      |
| Thuraaung\APIUtils\Http\Responses\API\PaginatedResponse::class   | It returns json response for pagination.   |
| Thuraaung\APIUtils\Http\Responses\API\FailResponse::class        | It returns json response for fail.         |
| Thuraaung\APIUtils\Http\Responses\API\MessageOnlyResponse::class | It returns json response for message-only. |
| Thuraaung\APIUtils\Http\Responses\API\Response::class            | API Utils Responses Class.                 |

```php
  use Thuraaung\APIUtils\Http\Responses\API\SuccessResponse;
  use Thuraaung\APIUtils\Http\Responses\API\PaginatedResponse;
  use Thuraaung\APIUtils\Http\Responses\API\FailResponse;
  use Thuraaung\APIUtils\Http\Responses\API\MessageOnlyResponse;
  use Thuraaung\APIUtils\Http\Responses\API\Response;

  // API Success Response with resource data.
  return new SuccessResponse($userResource); // OR
  return Response::of()->sendSuccess($userResource);

  // API Success Response with resource data.
  return new PaginatedResponse($userPaginationResource); // OR
  return Response::of()->paginated($userPaginationResource);

  // API Fail Response with errors.
  return new FailResponse(errors: ['email' => 'Email is invalid.']); // OR
  return Response::of()->sendFail(['email' => 'Email is invalid.']);

  // API Message-Only Response.
  return new MessageOnlyResponse('Login successful.', Status::OK); // OR
  return Response::of()
    ->status(Status::OK)
    ->sendMessage('Login successful.')
```

#### API Success JSON Response Format.

```json
{
    "data": "resource",
    "message": "Success.",
    "status": 200
}
```

#### API Paginated JSON Response Format.

```json
{
    "data": "resource",
    "links": {},
    "meta": {},
    "message": "Success.",
    "status": 200
}
```

#### A JSON Response Format for API Errors.

```json
{
    "title": "Failed!",
    "message": "Something went wrong!",
    "errors": [],
    "status": 500
}
```

#### A JSON Response Format for API Messages Only

```json
{
    "message": "Success",
    "status": 500
}
```

### Enums

| Class                                                  | Description               |
| ------------------------------------------------------ | ------------------------- |
| Thuraaung\APIUtils\Http\Responses\Status::class        | HTTP Status.              |
| Thuraaung\APIUtils\Http\Method::class                  | Request Methods.          |
| Thuraaung\APIUtils\Http\Scheme::class                  | Scheme.                   |
| Thuraaung\APIUtils\Http\Headers\Connection::class      | Connection Headers.       |
| Thuraaung\APIUtils\Http\Headers\ContentEncoding::class | Content Encoding Headers. |
| Thuraaung\APIUtils\Http\Headers\ContentType::class     | Content Type Headers.     |

### Headers

```php
    use Thuraaung\APIUtils\Http\Headers\Headers;
    use Thuraaung\APIUtils\Http\Headers\ContentType;
    use Thuraaung\APIUtils\Http\Headers\ContentEncoding;

    // Create headers with pre defined in config.
    Headers::default();
    // Transform array
    Headers::default()->toArray();

    // Other utils methods
    Headers::of()
        ->accept(ContentType::JSON)
        ->contentType(ContentType::JSON)
        ->acceptEncoding(ContentEncoding::GZIP)
        ->contentEncoding(ContentEncoding::GZIP, vapor: false)
        ->contentLength(214)
        ->toArray();
```

### Middleware Classes

| Class                                                          | Description                                           |
| -------------------------------------------------------------- | ----------------------------------------------------- |
| Thuraaung\APIUtils\Http\Middleware\GzipEncodingResponse::class | It is used to apply Gzip encoding to API responses.   |
| Thuraaung\APIUtils\Http\Middleware\JsonAPIResponse::class      | It is used to apply default headers to API responses. |

### Exceptions

| Class                                                     | Description                                                  |
| --------------------------------------------------------- | ------------------------------------------------------------ |
| Thuraaung\APIUtils\Exceptions\APIExceptionsHandler::class | It is used to handle API exceptions.                         |
| Thuraaung\APIUtils\Exceptions\Concerns\HasRender::class   | It is trait that used to custom exceptions for API response. |

> App\Exceptions\Handler.php

```php
    use Thuraaung\APIUtils\Exceptions\APIExceptionsHandler;

    class Handler extends APIExceptionsHandler
    {
        // others

        public function register(): void
        {
            $this->handleAuthenticationException()
                ->handleAccessDeniedException()
                ->handleNotFoundException()
                ->handleMethodNotAllowException()
                ->handleNotAcceptableException()
                ->handleUnprocessableEntityException()
                ->handleTooManyRequestsException()
                ->handleMergeExceptions([]);
        }

        protected function isJsonRequest(): bool
        {
            return \request()->isJson() && \request()->is('api/*');
        }
    }
```
