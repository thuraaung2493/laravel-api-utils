<?php

declare(strict_types=1);

use Thuraaung\APIUtils\Http\Headers\ContentType;

test('ContentType Enum Class', function (): void {
    expect(ContentType::class)->toBeEnum();

    expect(ContentType::cases())->toHaveLength(2);

    expect(ContentType::JSON->value)->toBe('application/json');
    expect(ContentType::IMAGE->value)->toBe('image/*');
});
