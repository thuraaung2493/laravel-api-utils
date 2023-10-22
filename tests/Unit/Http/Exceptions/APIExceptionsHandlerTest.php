<?php

declare(strict_types=1);

use Thuraaung\APIUtils\Exceptions\APIExceptionsHandler;

test('APIExceptionsHandler')
    ->expect(APIExceptionsHandler::class)
    ->toExtend('Illuminate\Foundation\Exceptions\Handler')
    ->toBeAbstract()
    ->toHaveMethod('handleAuthenticationException')
    ->toHaveMethod('handleAccessDeniedException')
    ->toHaveMethod('handleNotFoundException')
    ->toHaveMethod('handleMethodNotAllowException')
    ->toHaveMethod('handleNotAcceptableException')
    ->toHaveMethod('handleUnprocessableEntityException')
    ->toHaveMethod('handleTooManyRequestsException')
    ->toHaveMethod('handleMergeExceptions')
    ->toHaveMethod('toResponse')
    ->toHaveMethod('isJsonRequest');

describe('APIExceptionsHandler::class', function () {
    test('handleAuthenticationException', function () {
        $handler = new Handler(app());

        expect($handler->handleAuthenticationException())
            ->toBeInstanceOf(Handler::class);
    });

    test('handleAccessDeniedException', function () {
        $handler = new Handler(app());

        expect($handler->handleAccessDeniedException())
            ->toBeInstanceOf(Handler::class);
    });

    test('handleNotFoundException', function () {
        $handler = new Handler(app());

        expect($handler->handleNotFoundException())
            ->toBeInstanceOf(Handler::class);
    });

    test('handleMethodNotAllowException', function () {
        $handler = new Handler(app());

        expect($handler->handleMethodNotAllowException())
            ->toBeInstanceOf(Handler::class);
    });

    test('handleNotAcceptableException', function () {
        $handler = new Handler(app());

        expect($handler->handleNotAcceptableException())
            ->toBeInstanceOf(Handler::class);
    });

    test('handleUnprocessableEntityException', function () {
        $handler = new Handler(app());

        expect($handler->handleUnprocessableEntityException())
            ->toBeInstanceOf(Handler::class);
    });

    test('handleTooManyRequestsException', function () {
        $handler = new Handler(app());

        expect($handler->handleTooManyRequestsException())
            ->toBeInstanceOf(Handler::class);
    });

    test('handleMergeExceptions', function () {
        $handler = new Handler(app());

        expect($handler->handleMergeExceptions([]))
            ->toBeNull();
    });
});

class Handler extends APIExceptionsHandler
{
    protected function isJsonRequest(): bool
    {
        return true;
    }
}
