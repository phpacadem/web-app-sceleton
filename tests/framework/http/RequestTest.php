<?php

namespace tests\framework\http;

use framework\http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testEmpty(): void{
        $request = new Request();
        self::assertNull(null);
    }
}