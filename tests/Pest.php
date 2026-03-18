<?php

declare(strict_types=1);

use PittacusW\Excel\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

afterEach(static function (): void {
    Mockery::close();
});
