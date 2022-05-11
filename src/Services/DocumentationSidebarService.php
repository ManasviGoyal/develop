<?php

namespace Hyde\Framework\Services;

use Hyde\Framework\Concerns\HasDocumentationSidebarCategories;
use Hyde\Framework\Contracts\DocumentationSidebarServiceContract;
use Hyde\Framework\Models\DocumentationSidebar;
use Hyde\Framework\Models\DocumentationSidebarItem;

/**
 * Service class to create and manage the sidebar collection object.
 *
 * @see \Tests\Feature\Services\DocumentationSidebarServiceTest
 */
class DocumentationSidebarService implements DocumentationSidebarServiceContract
{
    use HasDocumentationSidebarCategories;

    /**
     * The sidebar object created and managed by the service instance.
     */
    protected DocumentationSidebar $sidebar;

    /**
     * Shorthand to create a new Sidebar object using default methods.
     */
    public static function get(): DocumentationSidebar
    {
        return ((new static)->createSidebar()->withoutIndex()->withoutHidden()->getSidebar()
        )->sortItems()->getCollection();
    }

    /**
     * Parse the _docs directory for sidebar items to create a new collection.
     */
    public function createSidebar(): self
    {
        $this->sidebar = new DocumentationSidebar();

        foreach ($this->getSidebarItems() as $slug) {
            $this->sidebar->addItem(
                $this->createSidebarItemFromSlug($slug)
            );
        }

        return $this;
    }

    /**
     * Get the sidebar object created and managed by the service instance.
     */
    public function getSidebar(): DocumentationSidebar
    {
        return $this->sidebar;
    }

    /**
     * Add an item to the sidebar collection.
     */
    public function addItem(DocumentationSidebarItem $item): self
    {
        $this->sidebar->addItem($item);

        return $this;
    }

    /**
     * Remove the index page from the sidebar collection.
     */
    protected function withoutIndex(): self
    {
        $this->sidebar = $this->sidebar->reject(function (DocumentationSidebarItem $item) {
            return $item->destination === 'index';
        });

        return $this;
    }

    /**
     * Remove hidden files from the sidebar collection.
     */
    protected function withoutHidden(): self
    {
        $this->sidebar = $this->sidebar->reject(function (DocumentationSidebarItem $item) {
            return $item->isHidden();
        });

        return $this;
    }

    /**
     * Get an array of source files to add to the sidebar.
     */
    protected function getSidebarItems(): array
    {
        return CollectionService::getDocumentationPageList();
    }

    /**
     * Generate a SidebarItem object from a source file referenced by its slug.
     */
    protected function createSidebarItemFromSlug(string $slug): DocumentationSidebarItem
    {
        return DocumentationSidebarItem::parseFromFile($slug);
    }
}
