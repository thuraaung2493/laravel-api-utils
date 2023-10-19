<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Thuraaung\APIUtils\Http\Responses\API\SuccessResponse;
use Thuraaung\APIUtils\Http\Responses\Status;

beforeEach(
    fn () =>
    $this->responseObj = new SuccessResponse(
        resource: new ResourceCollection(collect()),
        message: 'Created.',
        status: Status::CREATED
    )
);

it('can create a SuccessResponse class without message and status', function (): void {
    expect(new SuccessResponse(new ResourceCollection(collect())))
        ->toBeInstanceof(SuccessResponse::class)
        ->toHaveMethods(['toResponse']);
});

it('can create a SuccessResponse class with message and status', function (): void {
    expect($this->responseObj)
        ->toBeInstanceof(SuccessResponse::class)
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
        ->toBeArray()
        ->and($response->getData())
        ->toMatchObject([
            'data' => [],
            'message' => 'Created.',
            'status' => Status::CREATED->value,
        ]);
});
