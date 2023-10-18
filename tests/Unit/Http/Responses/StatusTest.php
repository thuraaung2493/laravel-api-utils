<?php

declare(strict_types=1);

use Thuraaung\APIUtils\Http\Responses\Status;

test('Status Enum Class', function () {
    expect(Status::class)->toBeEnum();

    expect(count(Status::cases()))->toBe(61);

    expect(Status::OK->value)->toBe(200);
    expect(Status::CREATED->value)->toBe(201);
    expect(Status::NO_CONTENT->value)->toBe(204);

    expect(Status::TEMPORARY_REDIRECT->value)->toBe(307);
    expect(Status::PERMANENT_REDIRECT->value)->toBe(308);

    expect(Status::BAD_REQUEST->value)->toBe(400);
    expect(Status::UNAUTHORIZED->value)->toBe(401);
    expect(Status::FORBIDDEN->value)->toBe(403);
    expect(Status::NOT_FOUND->value)->toBe(404);
    expect(Status::METHOD_NOT_ALLOWED->value)->toBe(405);
    expect(Status::NOT_ACCEPTABLE->value)->toBe(406);
    expect(Status::IM_A_TEAPOT->value)->toBe(418);
    expect(Status::UNPROCESSABLE_CONTENT->value)->toBe(422);
    expect(Status::TOO_MANY_REQUESTS->value)->toBe(429);

    expect(Status::INTERNAL_SERVER_ERROR->value)->toBe(500);
});
