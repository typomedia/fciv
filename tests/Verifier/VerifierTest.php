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
    public function testVerifySingle()
    {
        $input = __DIR__ . '/../Fixtures/test.xml';

        $validator = new Verifier('sha1');
        $fciv = $validator->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }

    /**
     * @throws Exception
     */
    public function testVerifyVendor()
    {
        $input = __DIR__ . '/../Fixtures/vendor.xml';

        $validator = new Verifier();
        $fciv = $validator->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }

    /**
     * @throws Exception
     */
    public function testVerifyBoth()
    {
        $input = __DIR__ . '/../Fixtures/finder.xml';

        $validator = new Verifier('both');
        $fciv = $validator->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }

    /**
     * @throws Exception
     */
    public function testVerifyException()
    {
        $input = __DIR__ . '/../Fixtures/win.xml';

        $this->expectException(InvalidHashException::class);

        $validator = new Verifier();
        $validator->verify(file_get_contents($input));
    }
}
