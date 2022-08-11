<?php

namespace Hyde\Framework\Commands;

use Hyde\Framework\Hyde;
use Illuminate\Foundation\Console\PackageDiscoverCommand as BaseCommand;
use Illuminate\Foundation\PackageManifest;

/**
 * @see \Hyde\Framework\Testing\Feature\Commands\HydePackageDiscoverCommandTest
 */
class HydePackageDiscoverCommand extends BaseCommand
{
    /** @var true */
    protected bool $hidden = true;

    public function handle(PackageManifest $manifest)
    {
        $manifest->manifestPath = Hyde::path('storage/framework/cache/packages.php');
        parent::handle($manifest);
    }
}
