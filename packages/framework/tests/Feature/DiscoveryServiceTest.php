<?php

namespace Hyde\Framework\Testing\Feature;

use Hyde\Framework\Exceptions\UnsupportedPageTypeException;
use Hyde\Framework\Hyde;
use Hyde\Framework\Models\Pages\BladePage;
use Hyde\Framework\Models\Pages\DocumentationPage;
use Hyde\Framework\Models\Pages\MarkdownPage;
use Hyde\Framework\Models\Pages\MarkdownPost;
use Hyde\Framework\Models\Parsers\DocumentationPageParser;
use Hyde\Framework\Models\Parsers\MarkdownPageParser;
use Hyde\Framework\Models\Parsers\MarkdownPostParser;
use Hyde\Framework\Services\DiscoveryService;
use Hyde\Testing\TestCase;
use Illuminate\Support\Facades\File;

class DiscoveryServiceTest extends TestCase
{
    public function createContentSourceTestFiles()
    {
        Hyde::touch((DiscoveryService::getModelSourceDirectory(MarkdownPost::class).'/test.md'));
        Hyde::touch((DiscoveryService::getModelSourceDirectory(MarkdownPage::class).'/test.md'));
        Hyde::touch((DiscoveryService::getModelSourceDirectory(DocumentationPage::class).'/test.md'));
        Hyde::touch((DiscoveryService::getModelSourceDirectory(BladePage::class).'/test.blade.php'));
    }

    public function deleteContentSourceTestFiles()
    {
        unlink(Hyde::path(DiscoveryService::getModelSourceDirectory(MarkdownPost::class).'/test.md'));
        unlink(Hyde::path(DiscoveryService::getModelSourceDirectory(MarkdownPage::class).'/test.md'));
        unlink(Hyde::path(DiscoveryService::getModelSourceDirectory(DocumentationPage::class).'/test.md'));
        unlink(Hyde::path(DiscoveryService::getModelSourceDirectory(BladePage::class).'/test.blade.php'));
    }

    public function test_get_parser_class_for_model()
    {
        $this->assertEquals(MarkdownPageParser::class, DiscoveryService::getParserClassForModel(MarkdownPage::class));
        $this->assertEquals(MarkdownPostParser::class, DiscoveryService::getParserClassForModel(MarkdownPost::class));
        $this->assertEquals(DocumentationPageParser::class, DiscoveryService::getParserClassForModel(DocumentationPage::class));
        $this->assertEquals(BladePage::class, DiscoveryService::getParserClassForModel(BladePage::class));
    }

    public function test_get_parser_instance_for_model()
    {
        $this->createContentSourceTestFiles();

        $this->assertInstanceOf(MarkdownPageParser::class, DiscoveryService::getParserInstanceForModel(MarkdownPage::class, 'test'));
        $this->assertInstanceOf(MarkdownPostParser::class, DiscoveryService::getParserInstanceForModel(MarkdownPost::class, 'test'));
        $this->assertInstanceOf(DocumentationPageParser::class, DiscoveryService::getParserInstanceForModel(DocumentationPage::class, 'test'));
        $this->assertInstanceOf(BladePage::class, DiscoveryService::getParserInstanceForModel(BladePage::class, 'test'));

        $this->deleteContentSourceTestFiles();
    }

    public function test_get_file_extension_for_model_files()
    {
        $this->assertEquals('.md', DiscoveryService::getFileExtensionForModelFiles(MarkdownPage::class));
        $this->assertEquals('.md', DiscoveryService::getFileExtensionForModelFiles(MarkdownPost::class));
        $this->assertEquals('.md', DiscoveryService::getFileExtensionForModelFiles(DocumentationPage::class));
        $this->assertEquals('.blade.php', DiscoveryService::getFileExtensionForModelFiles(BladePage::class));
    }

    public function test_get_file_path_for_model_class_files()
    {
        $this->assertEquals('_posts', DiscoveryService::getModelSourceDirectory(MarkdownPost::class));
        $this->assertEquals('_pages', DiscoveryService::getModelSourceDirectory(MarkdownPage::class));
        $this->assertEquals('_docs', DiscoveryService::getModelSourceDirectory(DocumentationPage::class));
        $this->assertEquals('_pages', DiscoveryService::getModelSourceDirectory(BladePage::class));
    }

    public function test_create_clickable_filepath_creates_link_for_existing_file()
    {
        $filename = 'be2329d7-3596-48f4-b5b8-deff352246a9';
        touch($filename);
        $output = DiscoveryService::createClickableFilepath($filename);
        $this->assertStringContainsString('file://', $output);
        $this->assertStringContainsString($filename, $output);
        unlink($filename);
    }

    public function test_create_clickable_filepath_falls_back_to_returning_input_if_file_does_not_exist()
    {
        $filename = 'be2329d7-3596-48f4-b5b8-deff352246a9';
        $output = DiscoveryService::createClickableFilepath($filename);
        $this->assertSame($filename, $output);
    }


    public function test_get_source_file_list_for_blade_page()
    {
        $this->assertEquals(['404', 'index'], DiscoveryService::getBladePageFiles());
    }

    public function test_get_source_file_list_for_markdown_page()
    {
        Hyde::touch(('_pages/foo.md'));
        $this->assertEquals(['foo'], DiscoveryService::getMarkdownPageFiles());
        unlink(Hyde::path('_pages/foo.md'));
    }

    public function test_get_source_file_list_for_markdown_post()
    {
        Hyde::touch(('_posts/foo.md'));
        $this->assertEquals(['foo'], DiscoveryService::getMarkdownPostFiles());
        unlink(Hyde::path('_posts/foo.md'));
    }

    public function test_get_source_file_list_for_documentation_page()
    {
        Hyde::touch(('_docs/foo.md'));
        $this->assertEquals(['foo'], DiscoveryService::getDocumentationPageFiles());
        unlink(Hyde::path('_docs/foo.md'));
    }

    public function test_get_source_file_list_for_model_method()
    {
        $this->unitTestMarkdownBasedPageList(MarkdownPage::class, '_pages/foo.md');
        $this->unitTestMarkdownBasedPageList(MarkdownPost::class, '_posts/foo.md');
        $this->unitTestMarkdownBasedPageList(DocumentationPage::class, '_docs/foo.md');
    }

    public function test_get_source_file_list_for_model_method_finds_customized_model_properties()
    {
        $matrix = [
            MarkdownPage::class,
            MarkdownPost::class,
            DocumentationPage::class,
        ];

        /** @var MarkdownPage $model */
        foreach ($matrix as $model) {
            // Setup
            @mkdir(Hyde::path('foo'));
            $sourceDirectoryBackup = $model::$sourceDirectory;
            $fileExtensionBackup = $model::$fileExtension;

            // Test baseline
            $this->unitTestMarkdownBasedPageList($model, $model::$sourceDirectory.'/foo.md');

            // Set the source directory to a custom value
            $model::$sourceDirectory = 'foo';

            // Test customized source directory
            $this->unitTestMarkdownBasedPageList($model, 'foo/foo.md');

            // Set file extension to a custom value
            $model::$fileExtension = '.foo';

            // Test customized file extension
            $this->unitTestMarkdownBasedPageList($model, 'foo/foo.foo', 'foo');

            // Cleanup
            File::deleteDirectory(Hyde::path('foo'));
            $model::$sourceDirectory = $sourceDirectoryBackup;
            $model::$fileExtension = $fileExtensionBackup;
        }
    }

    public function test_get_source_file_list_throws_exception_for_invalid_model_class()
    {
        $this->expectException(UnsupportedPageTypeException::class);

        DiscoveryService::getSourceFileListForModel('NonExistentModel');
    }

    public function test_get_media_asset_files()
    {
        $this->assertTrue(is_array(DiscoveryService::getMediaAssetFiles()));
    }

    public function test_get_media_asset_files_discovers_files()
    {
        $testFiles = [
            'png',
            'svg',
            'jpg',
            'jpeg',
            'gif',
            'ico',
            'css',
            'js',
        ];
        foreach ($testFiles as $fileType) {
            $path = Hyde::path('_media/test.'.$fileType);
            touch($path);
            $this->assertContains($path, DiscoveryService::getMediaAssetFiles());
            unlink($path);
        }
    }

    public function test_get_media_asset_files_discovers_custom_file_types()
    {
        $path = Hyde::path('_media/test.custom');
        touch($path);
        $this->assertNotContains($path, DiscoveryService::getMediaAssetFiles());
        config(['hyde.media_extensions' => 'custom']);
        $this->assertContains($path, DiscoveryService::getMediaAssetFiles());
        unlink($path);
    }

    public function test_blade_page_files_starting_with_underscore_are_ignored()
    {
        Hyde::touch(('_pages/_foo.blade.php'));
        $this->assertEquals([
            '404',
            'index',
        ], DiscoveryService::getBladePageFiles());
        unlink(Hyde::path('_pages/_foo.blade.php'));
    }

    public function test_markdown_page_files_starting_with_underscore_are_ignored()
    {
        Hyde::touch(('_pages/_foo.md'));
        $this->assertEquals([], DiscoveryService::getMarkdownPageFiles());
        unlink(Hyde::path('_pages/_foo.md'));
    }

    public function test_post_files_starting_with_underscore_are_ignored()
    {
        Hyde::touch(('_posts/_foo.md'));
        $this->assertEquals([], DiscoveryService::getMarkdownPostFiles());
        unlink(Hyde::path('_posts/_foo.md'));
    }

    public function test_documentation_page_files_starting_with_underscore_are_ignored()
    {
        Hyde::touch(('_docs/_foo.md'));
        $this->assertEquals([], DiscoveryService::getDocumentationPageFiles());
        unlink(Hyde::path('_docs/_foo.md'));
    }

    protected function unitTestMarkdownBasedPageList(string $model, string $path, ?string $expected = null)
    {
        Hyde::touch(($path));

        $expected = $expected ?? basename($path, '.md');

        $this->assertEquals([$expected], DiscoveryService::getSourceFileListForModel($model));

        unlink(Hyde::path($path));
    }
}
