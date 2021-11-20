<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class PrettyDisplayAllFilesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $files = cache()->tags(['file'])->rememberForever('all-files', function () {
            $filesystem = (new Filesystem);
            return collect($filesystem->allFiles(resource_path('scripts')))
                ->filter(fn (SplFileInfo $file) => !in_array($file->getBasename(), [
                    '.gitignore',
                    'LICENSE',
                    'README.md',
                    'logo.svg',
                ]))
                ->mapToGroups(function (SplFileInfo $file) {
                    $filePath = str_replace(resource_path('scripts/'), '', $file->getPath().'/'.$file->getBasename());
                    [$package, $distro, $script] = explode('/', $filePath);
                    return [
                        $package => [
                            'file_path' => $filePath,
                            'package' => $package,
                            'distro' => $distro,
                            'script' => $script,
                            'logo' => '/' . $package.'/logo.svg',
                        ]
                    ];
                })->map(function ($packageGroup) {
                    return collect($packageGroup)->groupBy('distro')->toArray();
                });
        });

        return view('welcome', [
            'files' => $files
        ]);
    }
}
