<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ScriptController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($package, $distro, $version = null) {
        $version = $this->getVersionIfNotSet($package, $distro, $version);
        $path = sprintf('%s/%s/%s', $package, $distro, $version);

        abort_unless(Storage::disk('scripts')->exists($path), 404);

        return response(
            cache()
                ->remember(
                    md5($path),
                    now()->addHour(),
                    fn () =>
                        Storage::disk('scripts')->get($path)), '200', [
                            'content-type' => 'text/text',
                        ]
        );
    }

    protected function getVersionIfNotSet($package, $distro, mixed $version)
    {
        if (empty($version)) {
            $latest = collect(Storage::disk('scripts')
                ->files(sprintf('%s/%s', $package, $distro)))
                ->map(fn($dir) => $dir)
                ->sortDesc()
                ->first();
            $parts = explode('/', $latest);
            $version = end($parts);
        }

        return $version;
    }
}
