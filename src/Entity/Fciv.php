<?php

namespace Typomedia\Fciv\Entity;

/**
 * Class Fciv
 * @package Typomedia\Fciv\Entity
 */
class Fciv
{
    /**
     * @var FileEntry[]
     */
    public $fileEntry;

    /**
     * @return FileEntry[]
     */
    public function getFileEntry()
    {
        return $this->fileEntry;
    }

    /**
     * @param FileEntry[] $fileEntry
     */
    public function setFileEntry(array $fileEntry)
    {
        $this->fileEntry = $fileEntry;
    }
}
