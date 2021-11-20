<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class GithubWebhooksController extends Controller
{
    public function __invoke(Request $request)
    {
        $expectedSignature = 'sha256='.hash_hmac('sha256', Request::getContent(), env('WEBHOOK_SECRET'));
        abort_unless($expectedSignature === request()->header('X-Hub-Signature-256'), 404);

        $updateSubmodules = new Process(['git', 'pull', '--ff', '--commit'], resource_path('scripts'));
        $updateSubmodules->run();
        cache()->tags(['file'])->flush();
        return 'OK';
    }
}