<?php

namespace Hyde\Framework\Concerns\Internal;

use Hyde\Framework\Models\Pages\DocumentationPage;
use Hyde\Framework\Models\Pages\MarkdownPost;

trait HasNavigationData
{
    public function showInNavigation(): bool
    {
        return ! $this->navigation['hidden'];
    }

    public function navigationMenuPriority(): int
    {
        return $this->navigation['priority'];
    }

    public function navigationMenuTitle(): string
    {
        return $this->navigation['title'];
    }

    protected function constructNavigationData(): void
    {
        $this->setNavigationData(
            $this->findNavigationMenuTitle(),
            ! $this->findNavigationMenuVisible(),
            $this->findNavigationMenuPriority(),
        );
    }

    protected function setNavigationData(string $label, bool $hidden, int $priority): void
    {
        $this->navigation = [
            'title' => $label,
            'hidden' => $hidden,
            'priority' => $priority,
        ];
    }

    /**
     * Note that this also affects the documentation sidebar titles.
     */
    private function findNavigationMenuTitle(): string
    {
        if ($this->matter('navigation.title') !== null) {
            return $this->matter('navigation.title');
        }

        if ($this->identifier === 'index') {
            if ($this instanceof DocumentationPage) {
                return config('hyde.navigation.labels.docs', 'Docs');
            }

            return config('hyde.navigation.labels.home', 'Home');
        }

        return $this->matter('title') ?? $this->title;
    }

    private function findNavigationMenuVisible(): bool
    {
        if ($this instanceof MarkdownPost) {
            return false;
        }

        if ($this instanceof DocumentationPage) {
            return $this->identifier === 'index' && ! in_array($this->routeKey, config('hyde.navigation.exclude', []));
        }

        if ($this->matter('navigation.hidden', false)) {
            return false;
        }

        if (in_array($this->identifier, config('hyde.navigation.exclude', ['404']))) {
            return false;
        }

        return true;
    }

    private function findNavigationMenuPriority(): int
    {
        if ($this->matter('navigation.priority') !== null) {
            return $this->matter('navigation.priority');
        }

        if (array_key_exists($this->routeKey, config('hyde.navigation.order', []))) {
            return (int) config('hyde.navigation.order.'.$this->routeKey);
        }

        return 999;
    }
}
