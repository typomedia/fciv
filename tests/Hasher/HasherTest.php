<?php

namespace Typomedia\Fciv\Tests\Hasher;

use PHPUnit\Framework\TestCase;
use Typomedia\Fciv\Hasher\Hasher;

class HasherTest extends TestCase
{
    public function testHashSingle()
    {
        $hasher = new Hasher();

        chdir(dirname(__DIR__, 2));
        $hasher->setEntries('src');

        $result = $hasher->getResult();
        $this->assertNotEmpty($result);

        file_put_contents(__DIR__ . '/../Fixtures/test.xml', $result);

    }

    public function testHashMultiple()
    {
        $hasher = new Hasher();

        chdir(dirname(__DIR__, 2));
        $hasher->setEntries('src');
        $hasher->setEntries('tests/Fixtures');

        $this->assertNotEmpty($hasher->getResult());

        file_put_contents(__DIR__ . '/../Fixtures/src.xml', $hasher->getResult());
    }


    public function testHashVendor()
    {
        $hasher = new Hasher();

        chdir(dirname(__DIR__, 2));
        $hasher->setEntries('vendor');

        $this->assertNotEmpty($hasher->getResult());

        file_put_contents(__DIR__ . '/../Fixtures/vendor.xml', $hasher->getResult());
    }
}
