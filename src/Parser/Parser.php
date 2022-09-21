<?php

namespace Typomedia\Fciv\Parser;

use Typomedia\Fciv\Entity\FCIV;
use Typomedia\Fciv\Transformer\Transformer;

/**
 * Class Parser
 * @package Typomedia\Fciv
 */
class Parser implements ParserInterface
{
    /**
     * @param string $data
     * @return false|string
     */
    public function parse(string $data)
    {
        $transformer = new Transformer();
        return $transformer->serializer->deserialize($data, FCIV::class, 'xml');
    }
}
