<?php

namespace Tests\Feature\Services;

use Tests\TestCase;
use Hyde\Framework\Hyde;
use Hyde\Framework\Services\CollectionService;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\MarkdownPage;
use Hyde\Framework\Models\MarkdownPost;
use Hyde\Framework\Models\DocumentationPage;
use Illuminate\Support\Facades\File;
use App\Commands\TestWithBackup;

class CollectionServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // TestWithBackup::backupDirectory(Hyde::path('_docs'));
        // File::deleteDirectory(Hyde::path('_docs'));
    }

    public function testClassExists()
    {
        $this->assertTrue(class_exists(CollectionService::class));
    }

    public function testGetSourceFileListForModelMethod()
    {
        $this->testListUnit(BladePage::class, 'resources/views/pages/a8a7b7ce.blade.php');
        $this->testListUnit(MarkdownPage::class, '_pages/a8a7b7ce.md');
        $this->testListUnit(MarkdownPost::class, '_posts/a8a7b7ce.md');
        $this->testListUnit(DocumentationPage::class, '_docs/a8a7b7ce.md');

        $this->assertFalse(CollectionService::getSourceFileListForModel('NonExistentModel'));
    }

    public function testGetMediaAssetFiles()
    {
        $this->assertTrue(is_array(CollectionService::getMediaAssetFiles()));
    }

    private function testListUnit(string $model, string $path)
    {
        touch(Hyde::path($path));

        $expected = str_replace(['.md', '.blade.php'], '', basename($path));

        $this->assertContains($expected, CollectionService::getSourceFileListForModel($model));

        unlink(Hyde::path($path));
    }

    public function tearDown(): void
    {
        // TestWithBackup::restoreDirectory(Hyde::path('_docs'));

        parent::tearDown();
    }
}
