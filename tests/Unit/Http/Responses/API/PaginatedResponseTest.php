<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\Paginator;
use Thuraaung\APIUtils\Http\Responses\API\PaginatedResponse;
use Thuraaung\APIUtils\Http\Responses\Status;

beforeEach(
    fn () =>
    $this->responseObj = new PaginatedResponse(
        resource: new ResourceCollection(new Paginator([], 1, 1)),
        message: 'Created.',
        status: Status::CREATED
    )
);

it('can create a PaginatedResponse class without message and status', function (): void {
    expect(new PaginatedResponse(new ResourceCollection(new Paginator([], 1, 1))))
        ->toBeInstanceof(PaginatedResponse::class)
        ->toHaveMethods(['toResponse']);
});

it('can create a PaginatedResponse class with message and status', function (): void {
    expect($this->responseObj)
        ->toBeInstanceof(PaginatedResponse::class)
        ->toHaveMethods(['toResponse']);
});

it('can create a Json Response', function (): void {
    $response = ($this->responseObj)
        ->toResponse(Request::create('/'));

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::CREATED->value)
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
            'message' => 'Created.',
            'status' => Status::CREATED->value,
        ]);
});
