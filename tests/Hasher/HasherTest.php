<?php

namespace Typomedia\Fciv\Tests\Hasher;

use PHPUnit\Framework\TestCase;
use Typomedia\Fciv\Hasher\Hasher;

class HasherTest extends TestCase
{
    public function setUp()
    {
        chdir(dirname(__DIR__, 2));
    }

    public function testHashSingle()
    {
        $hasher = new Hasher();
        $hasher->setEntries('src');

        $result = $hasher->getResult();
        $this->assertNotEmpty($result);

        file_put_contents(__DIR__ . '/../Fixtures/test.xml', $result);
    }

    public function testHashExclude()
    {
        $hasher = new Hasher();
        $hasher->setEntries('src', ['Converter', 'Entity']);

        $result = $hasher->getResult();
        $this->assertNotEmpty($hasher->getResult());
        $this->assertNotContains('src\Entity\FileEntry.php', $result);
        $this->assertNotContains('src\Entity\Fciv.php', $result);
        $this->assertNotContains('src\Converter\UpperCaseToCamelCaseConverter.php', $result);
        $this->assertNotContains('src\Converter\CamelCaseToUpperCaseConverter.php', $result);

        file_put_contents(__DIR__ . '/../Fixtures/exclude.xml', $result);
    }

    public function testHashMultiple()
    {
        $hasher = new Hasher();
        $hasher->setEntries('src');
        $hasher->setEntries('tests/Fixtures');

        $result = $hasher->getResult();
        $this->assertNotEmpty($result);

        file_put_contents(__DIR__ . '/../Fixtures/multi.xml', $result);
    }

    public function testHashVendor()
    {
        $hasher = new Hasher();
        $hasher->setEntries('vendor');

        $result = $hasher->getResult();
        $this->assertNotEmpty($result);

        file_put_contents(__DIR__ . '/../Fixtures/vendor.xml', $result);
    }
}
