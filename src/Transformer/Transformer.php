<?php

namespace Typomedia\Fciv\Transformer;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Typomedia\Fciv\Converter\CamelCaseToUpperCaseConverter;
use Typomedia\Fciv\Converter\UpperCaseToCamelCaseConverter;

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
        $serializer = new Serializer(
            [new ObjectNormalizer(
                null,
                new UpperCaseToCamelCaseConverter(),
                null,
                new ReflectionExtractor()
            )],
            [new XmlEncoder()]
        );

        $this->serializer = $serializer;
    }

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        return new Serializer([
            new ObjectNormalizer(
                null,
                new CamelCaseToUpperCaseConverter(),
                null,
                new ReflectionExtractor()
            ),
        ], [new XmlEncoder()]);
    }
}
