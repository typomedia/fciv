<?php

namespace Typomedia\Fciv\Tests\Verifier;

use Exception;
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
    }

    /**
     * @throws Exception
     */
    public function testVerifyException()
    {
        $input = __DIR__ . '/../Fixtures/win.xml';

        $this->expectException(InvalidHashException::class);

        $verifier = new Verifier();
        $verifier->verify(file_get_contents($input));
    }
}
