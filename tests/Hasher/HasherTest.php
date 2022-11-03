<?php

namespace Typomedia\Fciv\Tests\Hasher;

use PHPUnit\Framework\TestCase;
use Typomedia\Fciv\Hasher\Hasher;

class HasherTest extends TestCase
{
    public function setUp(): void
    {
        chdir(dirname(__DIR__, 2));
    }

    public function testHashSingle()
    {
        $hasher = new Hasher('sha1');
        $hasher->setEntries('src');

        $result = $hasher->getResult();
        $this->assertNotEmpty($result);
        $this->assertMatchesRegularExpression('/<SHA1>.{28}<\/SHA1>/', $result);

        file_put_contents(__DIR__ . '/../Fixtures/test.xml', $result);
    }

    public function testHashExclude()
    {
        $hasher = new Hasher();
        $hasher->setEntries('src', ['Converter', 'Entity', 'Exception\InvalidHashException.php']);

        $result = $hasher->getResult();
        file_put_contents(__DIR__ . '/../Fixtures/exclude.xml', $result);

        $this->assertNotEmpty($result);
        $this->assertMatchesRegularExpression('/<MD5>.{24}<\/MD5>/', $result);
        $this->assertStringNotContainsString('src\Entity\FileEntry.php', $result);
        $this->assertStringNotContainsString('src\Entity\Fciv.php', $result);
        $this->assertStringNotContainsString('src\Converter\UpperCaseToCamelCaseConverter.php', $result);
        $this->assertStringNotContainsString('src\Converter\CamelCaseToUpperCaseConverter.php', $result);
        $this->assertStringNotContainsString('src\Exception\InvalidHashException.php', $result);
    }

    public function testHashMultiple()
    {
        $hasher = new Hasher();
        $hasher->setEntries('src');
        $hasher->setEntries('tests/Fixtures');

        $result = $hasher->getResult();
        $this->assertNotEmpty($result);
        $this->assertMatchesRegularExpression('/<MD5>.{24}<\/MD5>/', $result);

        file_put_contents(__DIR__ . '/../Fixtures/multi.xml', $result);
    }

    public function testHashVendor()
    {
        $hasher = new Hasher('md5', ['*.json', '*.xml', '*.yml']);
        $hasher->setEntries('vendor', ['phpunit/phpunit/composer.json']);

        $result = $hasher->getResult();
        $this->assertNotEmpty($result);
        $this->assertMatchesRegularExpression('/<MD5>.{24}<\/MD5>/', $result);
        $this->assertStringNotContainsString('vendor\phpunit\phpunit\composer.json', $result);

        file_put_contents(__DIR__ . '/../Fixtures/vendor.xml', $result);
    }

    public function testHashNormalizePath()
    {
        $hasher = new Hasher('both', ['*.php']);
        $hasher->setEntries('vendor\symfony\finder', [
            'Iterator',
            'Comparator\DateComparator.php',
            'Comparator\NumberComparator.php',]);

        $result = $hasher->getResult();
        $this->assertNotEmpty($result);
        $this->assertMatchesRegularExpression('/<MD5>.{24}<\/MD5>/', $result);
        $this->assertMatchesRegularExpression('/<SHA1>.{28}<\/SHA1>/', $result);
        $this->assertStringNotContainsString('vendor\symfony\finder\Iterator', $result);
        $this->assertStringNotContainsString('Comparator\DateComparator.php', $result);
        $this->assertStringNotContainsString('Comparator\NumberComparator.php', $result);

        file_put_contents(__DIR__ . '/../Fixtures/finder.xml', $result);
    }
}
