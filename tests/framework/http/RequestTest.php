<?php

namespace tests\framework\http;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testEmpty(): void{
        self::assertNull(null);
    }
}