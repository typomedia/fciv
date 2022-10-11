<?php

namespace Typomedia\Fciv\Tests\Verifier;

use Exception;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Typomedia\Fciv\Exception\InvalidHashException;
use Typomedia\Fciv\Verifier\Verifier;
use PHPUnit\Framework\TestCase;

class VerifierTest extends TestCase
{
    public function setUp()
    {
        chdir(dirname(__DIR__, 2));
    }

    /**
     * @throws Exception
     */
    public function testVerifyMd5()
    {
        $input = __DIR__ . '/../Fixtures/vendor.xml';

        $verifier = new Verifier();
        $fciv = $verifier->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }

    /**
     * @throws Exception
     */
    public function testVerifySha1()
    {
        $input = __DIR__ . '/../Fixtures/test.xml';

        $verifier = new Verifier('sha1');
        $fciv = $verifier->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }

    /**
     * @throws Exception
     */
    public function testVerifyBoth()
    {
        $input = __DIR__ . '/../Fixtures/finder.xml';

        $verifier = new Verifier('both');
        $fciv = $verifier->verify(file_get_contents($input));

        $this->assertTrue($fciv);
        $this->assertEquals(8, $verifier->getCount());
    }

    /**
     * @throws Exception
     */
    public function testVerifyExclude()
    {
        $input = __DIR__ . '/../Fixtures/finder.xml';

        $verifier = new Verifier('both');
        $fciv = $verifier->verify(file_get_contents($input), [
            'vendor\symfony\finder\Exception\DirectoryNotFoundException.php',
            'vendor\symfony\finder\Exception\AccessDeniedException.php',
            ]
        );

        $this->assertTrue($fciv);
        $this->assertEquals(6, $verifier->getCount());
    }

    /**
     * @throws Exception
     */
    public function testVerifyInvalidHashException()
    {
        $input = __DIR__ . '/../Fixtures/win.xml';

        $this->expectException(InvalidHashException::class);

        $verifier = new Verifier();
        $verifier->verify(file_get_contents($input));
    }

    /**
     * @throws Exception
     */
    public function testVerifyEmptyFileException()
    {
        $input = __DIR__ . '/../Fixtures/empty.xml';

        $this->expectException(NotEncodableValueException::class);
        $this->expectExceptionMessage('Invalid XML data, it cannot be empty.');

        $verifier = new Verifier();
        $verifier->verify(file_get_contents($input));
    }
}
