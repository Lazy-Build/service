<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class UpdateScripts extends Command
{
    protected $signature = 'update-scripts';

    protected $description = 'Publish Package files to the public directory.';

    public function handle(Filesystem $filesystem)
    {
        $allFiles = $filesystem->allFiles(resource_path('scripts'));

        $logos = array_values(array_filter($allFiles, function ($file) {
            return $file->getBasename() === 'logo.svg';
        }));

        foreach($logos as $logo) {
            $basedir = public_path($logo->getRelativePathname());

            $filesystem->ensureDirectoryExists(dirname($basedir));

            $filesystem->copy($logo->getPathname(), $basedir);
        }
    }
}
