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
    public function getFileEntries(): array
    {
        return $this->fileEntry;
    }

    /**
     * @param FileEntry[] $fileEntry
     */
    public function setFileEntries(array $fileEntry): void
    {
        $this->fileEntry = $fileEntry;
    }

    /**
     * @param FileEntry $fileEntry
     */
    public function addFileEntry(FileEntry $fileEntry)
    {
        $this->fileEntry[] = $fileEntry;
    }
}
