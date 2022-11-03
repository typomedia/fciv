<?php

namespace Typomedia\Fciv\Tests\Converter;

use Typomedia\Fciv\Converter\CamelCaseToUpperCaseConverter;
use PHPUnit\Framework\TestCase;

class CamelCaseToUpperCaseConverterTest extends TestCase
{
    public function testDenormalize()
    {
        $converter = new CamelCaseToUpperCaseConverter();

        $this->assertEquals('fileEntry', $converter->denormalize('FILE_ENTRY'));
    }

    public function testDenormalizeLong()
    {
        $converter = new CamelCaseToUpperCaseConverter();

        $this->assertEquals('fileEntryLong', $converter->denormalize('FILE_ENTRY_LONG'));
    }

    public function testNormalize()
    {
        $converter = new CamelCaseToUpperCaseConverter();

        $this->assertEquals('FILE_ENTRY', $converter->normalize('fileEntry'));
    }

    public function testNormalizeLong()
    {
        $converter = new CamelCaseToUpperCaseConverter();

        $this->assertEquals('FILE_ENTRY_LONG', $converter->normalize('fileEntryLong'));
    }
}
