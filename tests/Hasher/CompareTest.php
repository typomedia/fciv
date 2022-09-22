<?php

namespace Typomedia\Fciv\Tests\Hasher;

use PHPUnit\Framework\TestCase;
use Typomedia\Fciv\Entity\Fciv;
use Typomedia\Fciv\Hasher\Hasher;
use Typomedia\Fciv\Transformer\Transformer;

class CompareTest extends TestCase
{
    public function testShitInShitOut()
    {
        $hasher = new Hasher();

        chdir(dirname(__DIR__, 2));
        $hasher->setEntries('tests');

        $expected = $hasher->getObject();

        $this->assertNotEmpty($expected);

        $transformer = new Transformer();
        $xml = $hasher->getResult();

        // shit happens here: $actual->fileEntry is just an numeric array instead of an array of FileEntry objects
        $actual = $transformer->serializer->deserialize(
            $xml,
            Fciv::class,
            'xml'
        );

        $this->assertEquals($expected, $actual);
    }
}
