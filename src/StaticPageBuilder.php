<?php

namespace Hyde\Framework;

use Hyde\Framework\Actions\MarkdownConverter;
use Hyde\Framework\Concerns\InteractsWithDirectories;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\DocumentationPage;
use Hyde\Framework\Models\MarkdownDocument;
use Hyde\Framework\Models\MarkdownPage;
use Hyde\Framework\Models\MarkdownPost;

/**
 * Converts a Page Model into a static HTML page.
 */
class StaticPageBuilder
{
    use InteractsWithDirectories;

    /**
     * @var string Absolute path to the directory to place compiled files in.
     */
    public static string $outputPath;

    /**
     * Construct the class.
     *
     * @param  MarkdownDocument|BladePage  $page  the Page to compile into HTML
     * @param  bool  $selfInvoke  if set to true the class will invoke when constructed
     */
    public function __construct(protected MarkdownDocument|BladePage $page, bool $selfInvoke = false)
    {
        if ($selfInvoke) {
            $this->__invoke();
        }

        $this->needsDirectory(static::$outputPath);
    }

    /**
     * Run the page builder.
     *
     * @return bool|int|void
     */
    public function __invoke()
    {
        if ($this->page instanceof BladePage) {
            return $this->save($this->page->view, $this->compileView());
        }

        if ($this->page instanceof MarkdownPost) {
            $this->needsDirectory(Hyde::getSiteOutputPath('posts'));

            return $this->save('posts/'.$this->page->slug, $this->compilePost());
        }

        if ($this->page instanceof MarkdownPage) {
            return $this->save($this->page->slug, $this->compilePage());
        }

        if ($this->page instanceof DocumentationPage) {
            $this->needsDirectory(Hyde::getSiteOutputPath(Hyde::docsDirectory()));

            return $this->save(Hyde::docsDirectory().'/'.$this->page->slug, $this->compileDocs());
        }
    }

    /**
     * Save the compiled HTML to file.
     *
     * @param  string  $location  of the output file relative to the site output directory
     * @param  string  $contents  to save to the file
     */
    private function save(string $location, string $contents): bool|int
    {
        $path = Hyde::getSiteOutputPath("$location.html");

        return file_put_contents($path, $contents);
    }

    /**
     * Compile a custom Blade View into HTML.
     *
     * @return string
     */
    private function compileView(): string
    {
        return view($this->page->view, [
            'currentPage' => $this->page->view,
        ])->render();
    }

    /**
     * Compile a Post into HTML using the Blade View.
     *
     * @return string
     */
    private function compilePost(): string
    {
        return view('hyde::layouts/post')->with([
            'post' => $this->page,
            'title' => $this->page->title,
            'markdown' => MarkdownConverter::parse($this->page->body),
            'currentPage' => 'posts/'.$this->page->slug,
        ])->render();
    }

    /**
     * Compile a Markdown Page into HTML using the Blade View.
     *
     * @return string
     */
    private function compilePage(): string
    {
        return view('hyde::layouts/page')->with([
            'title' => $this->page->title,
            'markdown' => MarkdownConverter::parse($this->page->body),
            'currentPage' => $this->page->slug,
        ])->render();
    }

    /**
     * Compile a Documentation page into HTML using the Blade View.
     *
     * @return string
     */
    private function compileDocs(): string
    {
        return view('hyde::layouts/docs')->with([
            'docs' => $this->page,
            'title' => $this->page->title,
            'markdown' => MarkdownConverter::parse($this->page->body, DocumentationPage::class),
            'currentPage' => Hyde::docsDirectory().'/'.$this->page->slug,
        ])->render();
    }
}
