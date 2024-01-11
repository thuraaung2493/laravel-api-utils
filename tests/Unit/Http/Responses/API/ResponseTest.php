<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Thuraaung\APIUtils\Http\Responses\Status;
use Thuraaung\APIUtils\Http\Responses\API\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

it('can create a Response class', function (): void {
    expect(Response::of())
        ->toBeInstanceof(Response::class)
        ->toHaveMethods([
            'of',
            'title',
            'message',
            'status',
            'sendSuccess',
            'sendFail',
            'sendMessage',
        ]);
});

it('can create a success json response', function (): void {
    $response = Response::of()->sendSuccess(new ResourceCollection(collect()))
        ->toResponse(Request::create('/'));

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::OK->value)
        ->and($response->headers->all())
        ->toBeArray()
        ->and($response->getData())
        ->toMatchObject([
            'data' => [],
            'message' => 'Success.',
            'status' => Status::OK->value,
        ]);
});

it('can create a success json response with custom message and status', function (): void {
    $response = Response::of()
        ->message('Filter successful.')
        ->status(Status::OK)
        ->sendSuccess(new ResourceCollection(collect()))
        ->toResponse(Request::create('/'));

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::OK->value)
        ->and($response->headers->all())
        ->toBeArray()
        ->and($response->getData())
        ->toMatchObject([
            'data' => [],
            'message' => 'Filter successful.',
            'status' => Status::OK->value,
        ]);
});

it('can create a fail json response', function (): void {
    $response = Response::of()->sendFail()
        ->toResponse(Request::create('/'));

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::INTERNAL_SERVER_ERROR->value)
        ->and($response->headers->all())
        ->toBeArray()
        ->and($response->getData())
        ->toMatchObject([
            'title' => 'Failed!',
            'errors' => [],
            'message' => 'Something went wrong!',
            'status' => Status::INTERNAL_SERVER_ERROR->value,
        ]);
});

it('can create a fail json response with custom errors, message and title', function (): void {
    $response = Response::of()
        ->title('Validation Errors!')
        ->message('Email field is required!')
        ->status(Status::UNPROCESSABLE_CONTENT)
        ->sendFail(['email' => 'Email is required.'])
        ->toResponse(Request::create('/'));

    $errors = new stdClass();
    $errors->email = "Email is required.";

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::UNPROCESSABLE_CONTENT->value)
        ->and($response->headers->all())
        ->toBeArray()
        ->and($response->getData())
        ->toMatchObject([
            'title' => 'Validation Errors!',
            'errors' => $errors,
            'message' => 'Email field is required!',
            'status' => Status::UNPROCESSABLE_CONTENT->value,
        ]);
});

it('can create a message-only json response', function (): void {
    $response = Response::of()->sendMessage()
        ->toResponse(Request::create('/'));

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::OK->value)
        ->and($response->headers->all())
        ->toBeArray()
        ->and($response->getData())
        ->toMatchObject([
            'message' => 'Success.',
            'status' => Status::OK->value,
        ]);
});

it('can create a message-only json response with custom message and status', function (): void {
    $response = Response::of()
        ->status(Status::CREATED)
        ->sendMessage('Created successful.')
        ->toResponse(Request::create('/'));

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::CREATED->value)
        ->and($response->headers->all())
        ->toBeArray()
        ->and($response->getData())
        ->toMatchObject([
            'message' => 'Created successful.',
            'status' => Status::CREATED->value,
        ]);
});

it('can create a paginated json response', function (): void {
    $response = Response::of()
        ->paginated(new ResourceCollection(new Paginator([], 1, 1)))
        ->toResponse(Request::create('/'));

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::OK->value)
        ->and($response->headers->all())
        ->toBeArray();

    $links = new stdClass();
    $links->first = '/?page=1';
    $links->last = null;
    $links->prev = null;
    $links->next = null;

    $meta = new stdClass();
    $meta->current_page = 1;
    $meta->from = null;
    $meta->path = '/';
    $meta->per_page = 1;
    $meta->to = null;

    expect($response->getData())
        ->toMatchObject([
            'data' => [],
            'links' => $links,
            'meta' => $meta,
            'message' => 'Success.',
            'status' => Status::OK->value,
        ]);
});

it('can create a paginated json response with custom message and status', function (): void {
    $response = Response::of()
        ->message('Filter successful.')
        ->status(Status::OK)
        ->paginated(new ResourceCollection(new Paginator([], 1, 1)))
        ->toResponse(Request::create('/'));

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::OK->value)
        ->and($response->headers->all())
        ->toBeArray();

    $links = new stdClass();
    $links->first = '/?page=1';
    $links->last = null;
    $links->prev = null;
    $links->next = null;

    $meta = new stdClass();
    $meta->current_page = 1;
    $meta->from = null;
    $meta->path = '/';
    $meta->per_page = 1;
    $meta->to = null;

    expect($response->getData())
        ->toMatchObject([
            'data' => [],
            'links' => $links,
            'meta' => $meta,
            'message' => 'Filter successful.',
            'status' => Status::OK->value,
        ]);
});
