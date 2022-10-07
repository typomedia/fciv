<?php

namespace Typomedia\Fciv\Tests\Validator;

use Exception;
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

        $validator = new Verifier();
        $fciv = $validator->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }

    public function testVerifyVendor()
    {
        $input = __DIR__ . '/../Fixtures/vendor.xml';

        $validator = new Verifier();
        $fciv = $validator->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }
}
