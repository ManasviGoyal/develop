<?php

namespace Hyde\Framework\Services;

use Hyde\Framework\Models\MarkdownPost;
use SimpleXMLElement;
use Hyde\Framework\Hyde;

/**
 * @see \Tests\Feature\Services\RssFeedServiceTest
 */
class RssFeedService
{
    public SimpleXMLElement $feed;
    protected float $time_start;

    public function __construct()
    {
        $this->time_start = microtime(true);

        $this->feed = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0" />');
        $this->feed->addAttribute('generator', 'HydePHP '.Hyde::version());
        $this->feed->addChild('channel');

        $this->addInitialChannelItems();
    }

    public function generate(): self
    {
        foreach (Hyde::getLatestPosts() as $post) {
            $this->addItem($post);
        }

        return $this;
    }

    public function getXML(): string
    {
        $this->feed->addAttribute('processing_time_ms', (string) round((microtime(true) - $this->time_start) * 1000, 2));

        return $this->feed->asXML();
    }

    protected function addItem(MarkdownPost $post): void
    {
        $item = $this->feed->channel->addChild('item');
        $item->addChild('title', $post->findTitleForDocument());
        $item->addChild('link', $post->getCanonicalLink());
        $item->addChild('description', $post->getPostDescription());
    }

    protected function addInitialChannelItems(): void
    {
        $this->feed->channel->addChild('title', $this->getTitle());
        $this->feed->channel->addChild('link', $this->getLink());
        $this->feed->channel->addChild('description', $this->getDescription());
    }

    protected function getTitle(): string
    {
        return $this->xmlEscape(
            config('hyde.name', 'HydePHP')
        );
    }

    protected function getLink(): string
    {
        return $this->xmlEscape(
            config('hyde.site_url') ?? 'http://localhost'
        );
    }

    protected function getDescription(): string
    {
        return $this->xmlEscape(
            config('hyde.rssDescription',
                $this->getTitle() . ' RSS Feed')
        );
    }

    protected function xmlEscape(string $string): string
    {
        return htmlspecialchars($string, ENT_XML1 | ENT_COMPAT, 'UTF-8');
    }
}

