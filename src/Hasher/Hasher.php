<?php

namespace Typomedia\Fciv\Hasher;

use Symfony\Component\Finder\Finder;
use Typomedia\Fciv\Entity\Fciv;
use Typomedia\Fciv\Entity\FileEntry;
use Typomedia\Fciv\Normalizer\Path;
use Typomedia\Fciv\Transformer\Transformer;

/**
 * Class Hasher
 * @package Typomedia\Fciv
 */
class Hasher implements HasherInterface
{
    /**
     * @var string $algo
     */
    private $algo;

    /**
     * @var array $types
     */
    private $types;

    /**
     * @var false|string
     */
    private $timeout;

/**
 * @param string $algo md5, sha1, both
 * @param array $types file name patterns to include
 * @param int|null $seconds timeout in seconds
 */
    public function __construct(string $algo = 'md5', array $types = [], int $seconds = null)
    {
        $this->algo = $algo;
        $this->types = $types;
        $this->timeout = ini_get('max_execution_time');

        if ($seconds !== null) {
            set_time_limit($seconds);
        }
    }

    /**
     * @var FileEntry[]
     */
    public $entries = [];

    /**
     * @var string
     */
    public $result;

    /**
     * @param string $path directory path
     * @param array $exclude paths to exclude
     * @return FileEntry[]
     */
    public function setEntries(string $path, array $exclude = []): array
    {
        $finder = new Finder();
        $path = Path::normalize($path);
        $exclude = array_map('\Typomedia\Fciv\Normalizer\Path::normalize', $exclude);
        $finder->files()->in($path)->name($this->types)->exclude($exclude); // exclude() only works with directories

        // ability to exclude files with relative path
        foreach ($exclude as $item) {
            if (is_file($path . '/' . $item)) {
                $finder->notPath($item);
            }
        }

        foreach ($finder as $file) {
            $entry = new FileEntry();
            $entry->setName($path . '/' . $file->getRelativePathname());

            switch ($this->algo) {
                case 'sha1':
                    $entry->setSha1Hash($file->getRealPath());
                    break;
                case 'both':
                    $entry->setMd5Hash($file->getRealPath());
                    $entry->setSha1Hash($file->getRealPath());
                    break;
                default:
                    $entry->setMd5Hash($file->getRealPath());
                    break;
            }

            $this->entries[] = $entry;
        }

        return $this->entries;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        $fciv = new Fciv();
        $fciv->fileEntry = $this->entries;

        $transformer = new Transformer();
        return $transformer->serializer->serialize($fciv, 'xml', [
            'xml_version' => '1.0',
            'xml_encoding' => 'utf-8',
            'xml_root_node_name' => 'FCIV',
            'xml_format_output' => true,
            'remove_empty_tags' => true,
        ]);
    }

    /**
     * @return Fciv
     */
    public function getObject(): Fciv
    {
        $fciv = new Fciv();
        $fciv->fileEntry = $this->entries;

        return $fciv;
    }

    public function __destruct()
    {
        // restore max_execution_time
        if ($this->timeout !== null) {
            ini_set('max_execution_time', $this->timeout);
        }
    }
}
