<?php

namespace Typomedia\Fciv\Hasher;

use Symfony\Component\Finder\Finder;
use Typomedia\Fciv\Entity\Fciv;
use Typomedia\Fciv\Entity\FileEntry;
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
    private string $algo;

    /**
     * @var array $types
     */
    private array $types;

    /**
     * @param string $algo
     * @param array $types
     */
    public function __construct(string $algo = 'md5', array $types = [])
    {
        $this->algo = $algo;
        $this->types = $types;
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
     * @param string $path
     * @param array $exclude
     * @return FileEntry[]
     */
    public function setEntries(string $path, array $exclude = []): array
    {
        $finder = new Finder();
        $finder->files()->in($path)->name($this->types)->exclude($exclude); // ecxlude() only works with directories

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
}
