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
     * @var string $algorithm
     */
    public function __construct(string $algorithm = 'md5')
    {
        $this->algorithm = $algorithm;
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
        $finder->files()->in($path)->exclude($exclude);

        foreach ($finder as $file) {
            $entry = new FileEntry();
            $entry->setName($path . '/' . $file->getRelativePathname());

            switch ($this->algorithm) {
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
            'xml_format_output' => true
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
