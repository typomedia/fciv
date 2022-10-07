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
     * @param FileEntry $fileEntry
     */
    public function addFileEntry(FileEntry $fileEntry)
    {
        $this->fileEntry[] = $fileEntry;
    }
}
