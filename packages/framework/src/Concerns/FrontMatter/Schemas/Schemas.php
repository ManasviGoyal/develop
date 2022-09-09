<?php

namespace Hyde\Framework\Concerns\FrontMatter\Schemas;

/**
 * Class representation of all the available schema traits with helpers to access them.
 *
 * All front matter properties are always optional in HydePHP.
 */
final class Schemas
{
    public static function getPageArray(): array
    {
        return [
            'title' => 'string',
            'navigation' => 'array',
            'canonicalUrl' => 'string',
        ];
    }
}
