<?php

namespace App\Console\Commands;

use App\Models\Script;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class UpdateScripts extends Command
{
    protected $signature = 'update-scripts';

    protected $description = 'Command description';

    protected $filesystem;

    public function __construct()
    {
        parent::__construct();
        $this->filesystem = Storage::disk('scripts');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $files = array_values(array_filter($this->filesystem->allFiles(), fn ($path) => Str::endsWith($path, '.sh')));

        foreach ($files as $file) {
            [$package, $distro, $scriptName] = explode('/', $file);

            $name = Str::title(str_replace('-', ' ', $package)) . ' on ' . $distro;

            $slug = Str::slug($package).'@'.$distro;

            Script::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'contents' => $this->filesystem->get($file),
            ]);
        }

        return Command::SUCCESS;
    }
}
