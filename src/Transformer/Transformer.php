<?php

namespace Typomedia\Fciv\Transformer;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Typomedia\Fciv\Converter\CamelCaseToUpperCaseConverter;

/**
 * Class Transformer
 * @package Typomedia\Fciv
 */
class Transformer
{
    /**
     * @var Serializer
     */
    public $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer(
            [new ObjectNormalizer(
                null,
                new CamelCaseToUpperCaseConverter(),
                null,
                new ReflectionExtractor()
            ), new ArrayDenormalizer()],
            [new XmlEncoder()]
        );
    }
}
