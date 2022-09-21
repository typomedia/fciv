<?php

namespace Typomedia\Fciv\Tests\Converter;

use Typomedia\Fciv\Converter\UpperCaseToCamelCaseConverter;
use PHPUnit\Framework\TestCase;

class UpperCaseToCamelCaseConverterTest extends TestCase
{
    public function testNormalize()
    {
        $converter = new UpperCaseToCamelCaseConverter();

        $this->assertEquals('fileEntry', $converter->normalize('FILE_ENTRY'));

    }

    public function testNormalizeLong()
    {
        $converter = new UpperCaseToCamelCaseConverter();

        $this->assertEquals('fileEntryLong', $converter->normalize('FILE_ENTRY_LONG'));

    }

    public function testDenormalize()
    {
        $converter = new UpperCaseToCamelCaseConverter();

        $this->assertEquals('FILE_ENTRY', $converter->denormalize('fileEntry'));

    }

    public function testDenormalizeLong()
    {
        $converter = new UpperCaseToCamelCaseConverter();

        $this->assertEquals('FILE_ENTRY_LONG', $converter->denormalize('fileEntryLong'));

    }
}
