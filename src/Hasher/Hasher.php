<?php

namespace Typomedia\Fciv\Hasher;

use Symfony\Component\Finder\Finder;
use Typomedia\Fciv\Entity\FCIV;
use Typomedia\Fciv\Entity\FILE_ENTRY;
use Typomedia\Fciv\Transformer\Transformer;

/**
 * Class Hasher
 * @package Typomedia\Fciv
 */
class Hasher implements HasherInterface
{
    /**
     * @var FILE_ENTRY[]
     */
    public $entries = [];

    /**
     * @var string
     */
    public $result;

    /**
     * @param string $path
     * @return FILE_ENTRY[]
     */
    public function setEntries(string $path): array
    {
        $finder = new Finder();
        $finder->files()->in($path);

        foreach ($finder as $file) {
            $entry = new FILE_ENTRY();
            $entry->setName($path . '/' . $file->getRelativePathname());
            $entry->setMD5($file->getRealPath());
            $entry->setSHA1($file->getRealPath());

            $this->entries[] = $entry;
        }

        return $this->entries;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        $fciv = new FCIV();
        $fciv->FILE_ENTRY = $this->entries;

        $transformer = new Transformer();
        return $transformer->serializer->serialize($fciv, 'xml', [
            'xml_version' => '1.0',
            'xml_encoding' => 'utf-8',
            'xml_root_node_name' => 'FCIV',
            'xml_format_output' => true
        ]);
    }
}
