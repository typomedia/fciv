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
     * @var FileEntry[]
     */
    public $entries = [];

    /**
     * @var string
     */
    public $result;

    /**
     * @param string $path
     * @return FileEntry[]
     */
    public function setEntries(string $path): array
    {
        $finder = new Finder();
        $finder->files()->in($path);

        foreach ($finder as $file) {
            $entry = new FileEntry();
            $entry->setName($path . '/' . $file->getRelativePathname());
            $entry->setMd5($file->getRealPath());
            $entry->setSha1($file->getRealPath());

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
        $fciv->setFileEntry($this->entries);

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
        $fciv->setFileEntry($this->entries);

        return $fciv;
    }
}
