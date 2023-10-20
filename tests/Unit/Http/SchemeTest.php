<?php

declare(strict_types=1);

use Thuraaung\APIUtils\Http\Scheme;

test('Scheme Enum Class', function (): void {
    expect(Scheme::class)->toBeEnum();

    expect(Scheme::cases())->toHaveLength(2);

    expect(Scheme::HTTP->value)->toBe('HTTP');
    expect(Scheme::HTTPS->value)->toBe('HTTPS');
});
