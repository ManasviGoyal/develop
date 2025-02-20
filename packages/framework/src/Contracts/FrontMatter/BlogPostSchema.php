<?php

namespace Hyde\Framework\Contracts\FrontMatter;

/**
 * @see \Hyde\Framework\Models\Pages\MarkdownPost
 */
interface BlogPostSchema extends Support\FeaturedImageSchema
{
    public const MARKDOWN_POST_SCHEMA = [
        'title'        => 'string',
        'description'  => 'string',
        'category'     => 'string',
        'date'         => 'string',
        'author'       => 'string|array|author',
        'image'        => 'string|array|featured_image',
    ];

    public const AUTHOR_SCHEMA = [
        'name'      => 'string',
        'username'  => 'string',
        'website'   => 'string|url',
    ];
}
