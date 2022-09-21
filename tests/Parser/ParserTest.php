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

        //print_r($fciv); die;
        //foreach ($files->getFileEntries() as $file) {
            //$this->assertNotEmpty($file->name);
            //print $file['name'] . ' ' . $file['MD5'] . PHP_EOL;
            //$this->assertNotEmpty($file->name);
            //$this->assertNotEmpty($file->MD5);
        //}

        $this->assertEquals('vendor\autoload.php', $files->fileEntry[0]['name']);
        $this->assertEquals('app\config\services.php', $files->fileEntry[11395]['name']);
        $this->assertEquals('VQ1dGvj0SVSjdtpMHGGlsQ==', $files->fileEntry[11395]['MD5']);
    }
}
