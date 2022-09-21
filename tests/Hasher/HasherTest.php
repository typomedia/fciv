<?php

namespace Typomedia\Fciv\Tests\Hasher;

use PHPUnit\Framework\TestCase;
use Typomedia\Fciv\Hasher\Hasher;

class HasherTest extends TestCase
{
    public function testCreate()
    {
        $hasher = new Hasher();

        chdir(dirname(__DIR__, 2));
        $hasher->setEntries('src');

        $result = $hasher->getResult();
        $this->assertNotEmpty($result);

        file_put_contents(__DIR__ . '/../Fixtures/test.xml', $result);

    }

    public function testCreate2()
    {
        $hasher = new Hasher();

        chdir(dirname(__DIR__, 2));
        $hasher->setEntries('src');
        $hasher->setEntries('tests/Fixtures');

        $this->assertNotEmpty($hasher->getResult());

        file_put_contents(__DIR__ . '/../Fixtures/src.xml', $hasher->getResult());
    }
}
