<?php

namespace Typomedia\Fciv\Tests\Hasher;

use PHPUnit\Framework\TestCase;
use Typomedia\Fciv\Hasher\Hasher;

class HasherTest extends TestCase
{
    public function testCreate()
    {
        $creator = new Hasher();

        chdir(dirname(__DIR__, 2));
        $creator->setEntries('src');

        $this->assertNotEmpty($creator->getResult());

        file_put_contents(__DIR__ . '/../Fixtures/test.xml', $creator->getResult());

    }

    public function testCreate2()
    {
        $creator = new Hasher();

        chdir(dirname(__DIR__, 2));
        $creator->setEntries('src');
        $creator->setEntries('tests/Fixtures');

        $this->assertNotEmpty($creator->getResult());

        file_put_contents(__DIR__ . '/../Fixtures/src.xml', $creator->getResult());
    }
}
