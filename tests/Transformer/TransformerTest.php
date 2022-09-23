<?php

namespace Typomedia\Fciv\Tests\Transformer;

use PHPUnit\Framework\TestCase;
use Typomedia\Fciv\Entity\Fciv;
use Typomedia\Fciv\Transformer\Transformer;

class TransformerTest extends TestCase
{
    public function testNormalize()
    {
        //$this->markTestSkipped('not impl yet');
        $transformer = new Transformer();

        $data = $transformer->serializer->denormalize(
            ['FILE_ENTRY' =>
                [[
                    'name' => 'foo',
                    'md5' => 'bar',
                    'sha1' => 'baz'
                ]]
            ],
            Fciv::class
        );

        $this->assertEquals('foo', $data->fileEntry[0]->name);
        $this->assertEquals('bar', $data->fileEntry[0]->md5);
        $this->assertEquals('baz', $data->fileEntry[0]->sha1);
    }

    public function testDeserialize()
    {
        $transformer = new Transformer();

        $data = file_get_contents(__DIR__ . '/../Fixtures/win.xml');
        $result = $transformer->serializer->deserialize($data,Fciv::class,'xml');

        $this->assertEquals('vendor\autoload.php', $result->fileEntry[0]->name);
    }
}