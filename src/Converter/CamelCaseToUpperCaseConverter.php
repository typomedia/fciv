<?php

namespace Typomedia\Fciv\Converter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class CamelCaseToUpperCaseConverter implements NameConverterInterface
{
    /**
     * Converts a string like 'fileEntry' to 'FILE_ENTRY'.
     */
    public function normalize(string $input): string
    {
        if ($input === 'name') {
            return $input;
        }

        $snakeCase = '';

        $len = \strlen($input);
        for ($i = 0; $i < $len; ++$i) {
            if (ctype_upper($input[$i])) {
                $snakeCase .= '_' . strtoupper($input[$i]);
            } else {
                $snakeCase .= strtoupper($input[$i]);
            }
        }

        return $snakeCase;
    }

    /**
     * Converts a string like 'FILE_ENTRY' to 'fileEntry'.
     */
    public function denormalize(string $input): string
    {
        $words =  ucwords(strtolower($input), '_');
        return lcfirst(str_replace('_', '', $words));
    }
}
