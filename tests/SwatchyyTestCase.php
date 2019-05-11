<?php

namespace Matik\Swatchyy\Tests;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

class SwatchyyTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}