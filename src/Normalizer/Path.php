<?php

namespace Typomedia\Fciv\Normalizer;

/**
 * Class Path
 * @package Typomedia\Fciv
 */
class Path
{
    /**
     * @param string $path
     * @return string
     */
    public static function normalize(string $path): string
    {
        return str_replace('\\', '/', $path);
    }
}
