<?php

namespace Typomedia\Fciv\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Typomedia\Fciv\Entity\Fciv;
use Typomedia\Fciv\Parser\Parser;

class ParserTest extends TestCase
{
    public function testParse()
    {
        $input = __DIR__ . '/../Fixtures/win.xml';

        $parser = new Parser();

        /** @var Fciv $files */
        $files = $parser->parse(file_get_contents($input));

        $this->assertEquals('vendor\autoload.php', $files->fileEntry[0]->name);
        $this->assertEquals('app\config\services.php', $files->fileEntry[11395]->name);
    }
}
