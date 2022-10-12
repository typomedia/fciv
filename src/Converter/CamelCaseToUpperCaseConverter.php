<?php

namespace Typomedia\Fciv\Converter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class CamelCaseToUpperCaseConverter implements NameConverterInterface
{
    /**
     * Converts a string like 'fileEntry' to 'FILE_ENTRY'.
     */
    public function normalize($propertyName): string
    {
        if ($propertyName === 'name') {
            return $propertyName;
        }

        $snakeCase = '';

        $len = \strlen($propertyName);
        for ($i = 0; $i < $len; ++$i) {
            if (ctype_upper($propertyName[$i])) {
                $snakeCase .= '_' . strtoupper($propertyName[$i]);
            } else {
                $snakeCase .= strtoupper($propertyName[$i]);
            }
        }

        return $snakeCase;
    }

    /**
     * Converts a string like 'FILE_ENTRY' to 'fileEntry'.
     */
    public function denormalize($propertyName): string
    {
        $words =  ucwords(strtolower($propertyName), '_');
        return lcfirst(str_replace('_', '', $words));
    }
}
