<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Thuraaung\APIUtils\Http\Responses\API\FailResponse;
use Thuraaung\APIUtils\Http\Responses\Status;

beforeEach(
    fn () =>
    $this->responseObj = new FailResponse(
        title: 'Validation Errors!',
        message: 'Email is required',
        errors: ['email' => 'Email is required'],
        status: Status::UNPROCESSABLE_CONTENT,
    )
);

it('can create a FailResponse class', function (): void {
    expect(new FailResponse())
        ->toBeInstanceof(FailResponse::class)
        ->toHaveMethods(['toResponse']);
});

it('can create a FailResponse class with errors, title, message and status', function (): void {
    expect($this->responseObj)
        ->toBeInstanceof(FailResponse::class)
        ->toHaveMethods(['toResponse']);
});

it('can create a Json Response', function (): void {
    $response = ($this->responseObj)
        ->toResponse(Request::create('/'));

    $errors = new stdClass();
    $errors->email = "Email is required";

    expect($response)
        ->toBeInstanceOf(JsonResponse::class)
        ->and($response->status())
        ->toEqual(Status::UNPROCESSABLE_CONTENT->value)
        ->and($response->headers->all())
        ->toBeArray()
        ->and($response->getData())
        ->toMatchObject([
            'title' => 'Validation Errors!',
            'message' => 'Email is required',
            'errors' => $errors,
            'status' => Status::UNPROCESSABLE_CONTENT->value,
        ]);
});
