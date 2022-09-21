<?php

namespace Typomedia\Fciv\Entity;

/**
 * Class FCIV
 * @package Typomedia\Fciv\Entity
 * @phpcs phpcs:ignoreFile
 */
class FCIV
{
    /**
     * @var FILE_ENTRY[]
     */
    public $FILE_ENTRY;

    /**
     * @return FILE_ENTRY[]
     */
    public function getFILE_ENTRY(): array
    {
        return $this->FILE_ENTRY;
    }

    /**
     * @param FILE_ENTRY[] $FILE_ENTRY
     */
    public function setFILE_ENTRY(array $FILE_ENTRY): void
    {
        $this->FILE_ENTRY = $FILE_ENTRY;
    }


}
