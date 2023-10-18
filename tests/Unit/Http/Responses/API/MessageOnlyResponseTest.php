<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Thuraaung\APIUtils\Http\Responses\Status;
use Thuraaung\APIUtils\Http\Responses\API\MessageOnlyResponse;

it('can create a MessageOnlyResponse class without message argument', function (): void {
    expect(new MessageOnlyResponse())
        ->toBeInstanceof(MessageOnlyResponse::class)
        ->toHaveMethods(['toResponse']);
});

it('can create a MessageOnlyResponse class with message argument', function (): void {
    expect(new MessageOnlyResponse('Success Message.'))
        ->toBeInstanceof(MessageOnlyResponse::class)
        ->toHaveMethods(['toResponse']);
});

it('can create a Json Response', function (): void {
    $response = (new MessageOnlyResponse('Success Message.'))
        ->toResponse(Request::create('/'));

    expect(
        $response,
    )->toBeInstanceOf(JsonResponse::class)->and(
        $response->status(),
    )->toEqual(Status::OK->value)->and(
        $response->headers->all(),
    )->toBeArray()->and(
        json_decode($response->getContent())
    )->toMatchObject([
        'message' => 'Success Message.',
        'status' => Status::OK->value,
    ]);
});
