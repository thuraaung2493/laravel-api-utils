<?php

declare(strict_types=1);

use Thuraaung\APIUtils\Http\Headers\Connection;

test('Connection Enum Class', function (): void {
    expect(Connection::class)->toBeEnum();

    expect(Connection::cases())->toHaveLength(2);

    expect(Connection::KEEP_ALIVE->value)->toBe('keep-alive');
    expect(Connection::CLOSE->value)->toBe('close');
});
