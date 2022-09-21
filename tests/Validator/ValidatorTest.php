<?php

namespace Typomedia\Fciv\Tests\Validator;

use Typomedia\Fciv\Verifier\Verifier;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    public function testValidate()
    {
        $input = __DIR__ . '/../Fixtures/test.xml';

        $validator = new Verifier();
        chdir(dirname(__DIR__, 2));
        $fciv = $validator->verify(file_get_contents($input));

        $this->assertTrue($fciv);
    }
}
