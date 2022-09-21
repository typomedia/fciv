<?php

namespace Typomedia\Fciv\Verifier;

use Exception;
use Typomedia\Fciv\Entity\FCIV;
use Typomedia\Fciv\Parser\Parser;

/**
 * Class Verifier
 * @package Typomedia\Fciv
 */
class Verifier implements VerifierInterface
{
    /**
     * @param string $data
     * @param null $path
     * @return bool|false
     * @throws Exception
     */
    public function verify(string $data, $path = null)
    {
        $parser = new Parser();

        /** @var FCIV $files */
        $files = $parser->parse($data);

        foreach ($files->FILE_ENTRY as $file) {
            $filename = $path ? $path . '/' . $file['name'] : $file['name'];
            $md5 = md5_file(str_replace('\\', DIRECTORY_SEPARATOR, $filename));

            if ($md5 !== bin2hex(base64_decode($file['MD5']))) {
                throw new Exception('MD5 mismatch for file: ' . $filename);
            }
        }

        return true;
    }
}
