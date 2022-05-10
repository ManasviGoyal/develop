<?php

namespace Hyde\Framework\Models;

use Hyde\Framework\Hyde;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/**
 * Object containing information for a sidebar item.
 *
 * @see \Tests\Feature\Services\DocumentationSidebarServiceTest
 */
class DocumentationSidebarItem
{
    public string $label;
    public string $destination;
    public int $priority;
    public bool $hidden = false;

    public function __construct(string $label, string $destination, ?int $priority = null, bool $hidden = false)
    {
        $this->label = $label;
        $this->destination = $destination;
        $this->priority = $priority ?? $this->findPriorityInConfig($destination);
        $this->hidden = $hidden;
    }

    protected function findPriorityInConfig(string $slug): int
    {
        $orderIndexArray = config('hyde.documentationPageOrder', []);

        if (! in_array($slug, $orderIndexArray)) {
            return 500;
        }

        return array_search($slug, $orderIndexArray); //  + 250?
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public static function parseFromFile(string $documentationPageSlug): static
    {
        $matter = YamlFrontMatter::markdownCompatibleParse(
            file_get_contents(Hyde::path('_docs/'.$documentationPageSlug.'.md'))
        )->matter();

        return new static(
            $matter['label'] ?? Hyde::titleFromSlug($documentationPageSlug),
            $documentationPageSlug,
            $matter['priority'] ?? null,
            $matter['hidden'] ?? false
        );
    }
}
