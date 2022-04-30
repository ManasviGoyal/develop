<?php

namespace Hyde\Framework\Commands;

use Exception;
use Hyde\Framework\Actions\CreatesNewPageSourceFile;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\MarkdownPage;
use LaravelZero\Framework\Commands\Command;

/**
 * Hyde Command to scaffold a new Markdown or Blade page file.
 * @todo Ask for title if it was not specified.
 */
class HydeMakePageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:page 
		{title : The name of the page file to create. Will be used to generate the slug}
		{--type=markdown : The type of page to create (markdown or blade)}
		{--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new Markdown or Blade page file';

    /**
     * The page title.
     */
    public string $title;

    /**
     * The page type.
     */
    public string $type;

    /**
     * Can the file be overwritten?
     */
    public bool $force;

    /**
     * Execute the console command.
     *
     * @return int the exit code of the command.
     *
     * @throws Exception if the page type is invalid.
     */
    public function handle(): int
    {
        $this->title('Creating a new page!');

        $this->title = $this->argument('title');

        $this->validateOptions();

        $this->force = $this->option('force') ?? false;

        $creator = new CreatesNewPageSourceFile($this->title, $this->type, $this->force);

        $this->info("Created file $creator->path");

        return 0;
    }

    /**
     * Validate the options passed to the command.
     *
     * @return void
     *
     * @throws Exception if the page type is invalid.
     */
    protected function validateOptions(): void
    {
        $type = strtolower($this->option('type') ?? 'markdown');

        if (! in_array($type, ['markdown', 'blade'])) {
            throw new Exception("Invalid page type: $type", 400);
        }

        // Set the type to the fully qualified class name
        if ($type === 'markdown') {
            $this->type = MarkdownPage::class;
        } else {
            $this->type = BladePage::class;
        }
    }
}
