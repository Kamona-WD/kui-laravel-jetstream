<?php

namespace KUI\Jetstream\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class ReplaceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kui-jetstream:replace {stack : The development stack that should be replaced (livewire,inertia)}
                            {--composer=global : Absolute path to the Composer binary which should be used to install packages}
                            {--vite : Vitejs}
                            {--teams : Indicates if team support should be replaced}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace laravel\\jetstream views.';

    protected $isVite = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->writeLogo();

        $this->replaceFavIcon();

        if (file_exists(base_path('vite.config.js')) || $this->option('vite')) {
            $this->isVite = true;
        }

        if ($this->argument('stack') === 'inertia') {
            return $this->replaceInertia();
        }

        if ($this->argument('stack') === 'livewire') {
            return $this->replaceLivewire();
        }
    }

    public function replaceInertia()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            $extraPackages = [
                '@heroicons/vue' => '^1.0.4',
                // '@headlessui/vue' => '^1.4.3',
                "@inertiajs/inertia" => "^0.11.1",
                "@inertiajs/inertia-vue3" => "^0.6.0",
                "@inertiajs/progress" => "^0.2.7",
                '@vueuse/core' => '^6.5.3',
                'perfect-scrollbar' => '^1.5.5',
                'vue-toastification' => '^2.0.0-rc.1'
            ] + $packages;

            if (!$this->isVite) {
                $extraPackages += ['@vue/babel-plugin-jsx' => '^1.1.0'];
            } else {
                $extraPackages += ['@vitejs/plugin-vue-jsx' => '^1.3.10'];
            }

            return $extraPackages + $packages;
        });

        // Components + Pages...
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Components'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Composables'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Toast'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/inertia/js/Components', resource_path('js/Components'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/inertia/js/Composables', resource_path('js/Composables'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/inertia/js/Layouts', resource_path('js/Layouts'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/inertia/js/Pages', resource_path('js/Pages'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/inertia/js/Toast', resource_path('js/Toast'));


        copy(__DIR__ . '/../../stubs/inertia/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__ . '/../../stubs/inertia/css/app.css', resource_path('css/app.css'));

        if (!$this->isVite) {
            copy(__DIR__ . '/../../stubs/inertia/views/app.mix.blade.php', resource_path('views/app.blade.php'));
            copy(__DIR__ . '/../../stubs/inertia/.babelrc', base_path('.babelrc'));
            copy(__DIR__ . '/../../stubs/inertia/webpack.config.js', base_path('webpack.config.js'));
            copy(__DIR__ . '/../../stubs/inertia/webpack.mix.js', base_path('webpack.mix.js'));
            copy(__DIR__ . '/../../stubs/inertia/js/app.mix.js', resource_path('js/app.js'));
        } else {
            copy(__DIR__ . '/../../stubs/inertia/views/app.vite.blade.php', resource_path('views/app.blade.php'));
            copy(__DIR__ . '/../../stubs/inertia/vite.config.js', base_path('vite.config.js'));
            copy(__DIR__ . '/../../stubs/inertia/js/app.vite.js', resource_path('js/app.js'));
            copy(__DIR__ . '/../../stubs/common/postcss.config.js', base_path('postcss.config.js'));
        }

        if ($this->option('teams')) {
            (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/Teams'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/inertia/js/Teams', resource_path('js/Pages/Teams'));
        }

        $this->info('Jetstream ui scaffolding replaced successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    public function replaceLivewire()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                '@alpinejs/collapse' => '^3.4.2',
                'perfect-scrollbar' => '^1.5.5'
            ] + $packages;
        });

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/api'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/profile'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/livewire/views/api', resource_path('views/api'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/livewire/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/livewire/views/components', resource_path('views/components'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/livewire/views/profile', resource_path('views/profile'));

        copy(__DIR__ . '/../../stubs/livewire/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));
        copy(__DIR__ . '/../../stubs/livewire/views/navigation-menu.blade.php', resource_path('views/navigation-menu.blade.php'));
        copy(__DIR__ . '/../../stubs/livewire/views/policy.blade.php', resource_path('views/policy.blade.php'));
        copy(__DIR__ . '/../../stubs/livewire/views/terms.blade.php', resource_path('views/terms.blade.php'));

        // Assets
        copy(__DIR__ . '/../../stubs/livewire/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__ . '/../../stubs/livewire/css/app.css', resource_path('css/app.css'));

        if (!$this->isVite) {
            copy(__DIR__ . '/../../stubs/livewire/views/layouts/app.mix.blade.php', resource_path('views/layouts/app.blade.php'));
            copy(__DIR__ . '/../../stubs/livewire/views/layouts/guest.mix.blade.php', resource_path('views/layouts/guest.blade.php'));
            copy(__DIR__ . '/../../stubs/livewire/views/welcome.mix.blade.php', resource_path('views/welcome.blade.php'));
            copy(__DIR__ . '/../../stubs/livewire/webpack.mix.js', base_path('webpack.mix.js'));
            copy(__DIR__ . '/../../stubs/livewire/js/app.mix.js', resource_path('js/app.js'));
        } else {
            copy(__DIR__ . '/../../stubs/livewire/views/layouts/app.vite.blade.php', resource_path('views/layouts/app.blade.php'));
            copy(__DIR__ . '/../../stubs/livewire/views/layouts/guest.vite.blade.php', resource_path('views/layouts/guest.blade.php'));
            copy(__DIR__ . '/../../stubs/livewire/views/welcome.vite.blade.php', resource_path('views/welcome.blade.php'));
            copy(__DIR__ . '/../../stubs/livewire/vite.config.js', base_path('vite.config.js'));
            copy(__DIR__ . '/../../stubs/livewire/js/app.vite.js', resource_path('js/app.js'));
            copy(__DIR__ . '/../../stubs/common/postcss.config.js', base_path('postcss.config.js'));
        }

        if ($this->option('teams')) {
            (new Filesystem)->ensureDirectoryExists(resource_path('views/teams'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/livewire/views/teams', resource_path('views/teams'));
        }

        // Icons
        $this->requireComposerPackages('blade-ui-kit/blade-heroicons:^1.2');

        $this->info('Jetstream ui scaffolding replaced successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    protected function replaceFavIcon()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('public'));
        copy(__DIR__ . '/../../stubs/common/favicon.ico', base_path('public/favicon.ico'));
    }

    protected function writeLogo()
    {
        $logo = PHP_EOL . '<fg=bright-blue>
██╗  ██╗     ██╗   ██╗██╗
██║ ██╔╝     ██║   ██║██║
█████╔╝█████╗██║   ██║██║
██╔═██╗╚════╝██║   ██║██║
██║  ██╗     ╚██████╔╝██║
╚═╝  ╚═╝      ╚═════╝ ╚═╝
        </>' . PHP_EOL;

        return $this->line($logo);
    }
}
