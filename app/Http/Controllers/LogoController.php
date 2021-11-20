<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $package)
    {
        return cache()
            ->tags(['file', 'logo'])
            ->rememberForever(
                $package.'.logo.svg',
                fn() => response(Storage::disk('scripts')->get(sprintf('%s/logo.svg', $package)), 200, [
                    'content-type' => 'image/svg+xml'
                ])
            );
    }
}
