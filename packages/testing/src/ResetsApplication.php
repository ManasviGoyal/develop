<?php

namespace Hyde\Testing;

use Hyde\Framework\Hyde;

/**
 * @internal
 */
trait ResetsApplication
{
    public function resetApplication()
    {
        $this->resetMedia();
        $this->resetPages();
        $this->resetPosts();
        $this->resetDocs();
        $this->resetSite();
    }

    public function resetMedia()
    {
        //
    }

    public function resetPages()
    {
        array_map('unlinkUnlessDefault', glob(Hyde::path('_pages/*.md')));
        array_map('unlinkUnlessDefault', glob(Hyde::path('_pages/*.blade.php')));
    }

    public function resetPosts()
    {
        array_map('unlinkUnlessDefault', glob(Hyde::path('_posts/*.md')));
    }

    public function resetDocs()
    {
        array_map('unlinkUnlessDefault', glob(Hyde::path('_docs/*.md')));
    }

    public function resetSite()
    {
        array_map('unlinkUnlessDefault', glob(Hyde::path('_site/**/*.html')));
        array_map('unlinkUnlessDefault', glob(Hyde::path('_site/**/*.json')));
        array_map('unlinkUnlessDefault', glob(Hyde::path('_site/*.xml')));
    }

    public function restoreDefaultPages()
    {
        copy(Hyde::vendorPath('resources/views/homepages/welcome.blade.php'), Hyde::path('_pages/index.blade.php'));
        copy(Hyde::vendorPath('resources/views/pages/404.blade.php'), Hyde::path('_pages/404.blade.php'));
    }
}
