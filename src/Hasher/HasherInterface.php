<?php

namespace Typomedia\Fciv\Hasher;

/**
 * Interface HasherInterface
 * @package Typomedia\Fciv
 */
interface HasherInterface
{
    /**
     * @param string $path
     * @return mixed
     */
    public function setEntries(string $path);
}
