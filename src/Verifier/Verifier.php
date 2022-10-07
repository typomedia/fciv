<?php

namespace Typomedia\Fciv\Verifier;

use Exception;
use Typomedia\Fciv\Entity\Fciv;
use Typomedia\Fciv\Entity\FileEntry;
use Typomedia\Fciv\Parser\Parser;

/**
 * Class Verifier
 * @package Typomedia\Fciv
 */
class Verifier implements VerifierInterface
{
    /**
     * @var string $algorithm
     */
    public function __construct(string $algorithm = 'md5')
    {
        $this->algorithm = $algorithm;
    }

    /**
     * @param string $data
     * @param null $path
     * @return bool|false
     * @throws Exception
     */
    public function verify(string $data, $path = null)
    {
        $parser = new Parser();

        /** @var Fciv $files */
        $files = $parser->parse($data);

        foreach ($files->fileEntry as $file) {
            $filename = $path ? $path . '/' . $file->name : $file->name;

            switch ($this->algorithm) {
                case 'sha1':
                    $sha1 = sha1_file(str_replace('\\', DIRECTORY_SEPARATOR, $filename));
                    if ($sha1 !== bin2hex(base64_decode($file->sha1))) {
                        throw new Exception(' SHA-1: ' . $file->sha1 . ' mismatch for file: ' . $filename);
                    }
                    break;
                case 'both':
                    $sha1 = sha1_file(str_replace('\\', DIRECTORY_SEPARATOR, $filename));
                    $md5 = md5_file(str_replace('\\', DIRECTORY_SEPARATOR, $filename));
                    break;
                default:
                    $md5 = md5_file(str_replace('\\', DIRECTORY_SEPARATOR, $filename));
                    if ($md5 !== bin2hex(base64_decode($file->md5))) {
                        throw new Exception(' MD5: ' . $file->md5 . ' mismatch for file: ' . $filename);
                    }
                    break;
            }

        }

        return true;
    }
}
