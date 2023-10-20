<?php

declare(strict_types=1);

use Thuraaung\APIUtils\Http\Headers\Enums\ContentEncoding;

test('ContentEncoding Enum Class', function () {
    expect(ContentEncoding::class)->toBeEnum();

    expect(ContentEncoding::cases())->toHaveLength(3);

    expect(ContentEncoding::COMPRESS->value)->toBe('compress');
    expect(ContentEncoding::DEFLATE->value)->toBe('deflate');
    expect(ContentEncoding::GZIP->value)->toBe('gzip');
});