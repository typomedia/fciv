<?php

namespace Typomedia\Fciv\Verifier;

use Exception;
use Typomedia\Fciv\Entity\Error;
use Typomedia\Fciv\Entity\Fciv;
use Typomedia\Fciv\Exception\InvalidHashException;
use Typomedia\Fciv\Normalizer\Path;
use Typomedia\Fciv\Parser\Parser;

/**
 * Class Verifier
 * @package Typomedia\Fciv
 */
class Verifier implements VerifierInterface
{
    /**
     * @var string $algo
     */
    private $algo;

    /**
     * @var string|null $file
     */
    private $file;

    /**
     * @var int $count
     */
    private $count = 0;

    /**
     * @var Error[] $errors
     */
    private $errors = [];

    /**
     * @var string $algo
     */
    public function __construct(string $algo = 'md5')
    {
        $this->algo = $algo;
    }

    /**
     * @param string $data
     * @param array $exclude
     * @param null $path
     * @return bool
     * @throws InvalidHashException
     */
    public function verify(string $data, array $exclude = [], $path = null): bool
    {
        $parser = new Parser();

        /** @var Fciv $files */
        $files = $parser->parse($data);

        foreach ($files->fileEntry as $file) {
            // win directory sparator for compatibility
            $this->file = $path ? $path . '\\' . $file->name : $file->name;

            if (in_array($this->file, $exclude, true)) {
                continue;
            }

            switch ($this->algo) {
                case 'sha1':
                    $expected = $this->decode($file->sha1);
                    $this->compare($this->hash(), $expected);
                    break;
                case 'both':
                    $this->algo = 'sha1';
                    $expected = $this->decode($file->sha1);
                    $this->compare($this->hash(), $expected);
                    $this->algo = 'md5';
                    $expected = $this->decode($file->md5);
                    $this->compare($this->hash(), $expected);
                    break;
                default:
                    $expected = $this->decode($file->md5);
                    $this->compare($this->hash(), $expected);
                    break;
            }
        }

        if ($this->errors) {
            throw new InvalidHashException($this->errors);
        }

        return true;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param string $data
     * @return string
     */
    protected function decode(string $data): string
    {
        return bin2hex(base64_decode($data));
    }

    /**
     * @return string
     */
    protected function hash(): string
    {
        // replace win directory separator in $filename on linux
        $file = Path::normalize($this->file);
        if (!file_exists($file)) {
            return false;
        }

        return hash_file($this->algo, $file);
    }

    /**
     * @param string $hash
     * @param string $expected
     * @return bool
     */
    protected function compare(string $hash, string $expected): bool
    {
        if ($hash !== $expected) {
            $error = new Error();
            $error->file = $this->file;
            $error->algo = $this->algo;
            $error->hash = $expected;

            $this->errors[] = $error;
        }

        $this->count++;
        return true;
    }
}
