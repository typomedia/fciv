<?php

namespace Typomedia\Fciv\Tests\Validator;

use Exception;
use Typomedia\Fciv\Verifier\Verifier;
use PHPUnit\Framework\TestCase;

class VerifierTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testVerifySingle()
    {
        $input = __DIR__ . '/../Fixtures/test.xml';

        $validator = new Verifier();
        chdir(dirname(__DIR__, 2));
        $fciv = $validator->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }

    public function testVerifyVendor()
    {
        $input = __DIR__ . '/../Fixtures/vendor.xml';

        $validator = new Verifier();
        chdir(dirname(__DIR__, 2));
        $fciv = $validator->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }
}
