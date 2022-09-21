<?php

namespace Typomedia\Fciv\Parser;

/**
 * Interface ParserInterface
 * @package Typomedia\Fciv
 */
interface ParserInterface
{
    /**
     * @param string $data
     * @return mixed
     */
    public function parse(string $data);
}
