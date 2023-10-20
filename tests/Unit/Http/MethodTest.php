<?php

declare(strict_types=1);

use Thuraaung\APIUtils\Http\Method;

test('Method Enum Class', function () {
    expect(Method::class)->toBeEnum();

    expect(Method::cases())->toHaveLength(8);

    expect(Method::GET->value)->toBe('GET');
    expect(Method::POST->value)->toBe('POST');
    expect(Method::PUT->value)->toBe('PUT');
    expect(Method::PATCH->value)->toBe('PATCH');
    expect(Method::DELETE->value)->toBe('DELETE');
    expect(Method::OPTIONS->value)->toBe('OPTIONS');
    expect(Method::HEAD->value)->toBe('HEAD');
    expect(Method::TRACE->value)->toBe('TRACE');
});
