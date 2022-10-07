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
     * @param array $exclude
     * @return mixed
     */
    public function setEntries(string $path, array $exclude);
}
