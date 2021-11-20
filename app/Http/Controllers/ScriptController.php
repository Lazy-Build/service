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
        if (empty($version)) {
            $path = sprintf('%s/%s/install.sh', $package, $distro);
        } else {
            $path = sprintf('%s/%s/%s', $package, $distro, $version);
        }

        abort_unless(Storage::disk('scripts')->exists($path), 404);

        return response(
            cache()->tags(['file'])->rememberForever(md5($path), fn () => Storage::disk('scripts')->get($path)), '200', [
            'content-type' => 'text/text',
        ]);
    }
}
