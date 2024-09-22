<?php

declare(strict_types=1);

use Illuminate\Console\View\Components\Choice;
use Illuminate\Log\LogManager;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Symfony\Component\Console\Question\ChoiceQuestion;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Warnings about re-declarations of google_* classes are a known feature
 * of the google/apiclient package when using the PHP 7.4+ preload.
 * These warnings do not affect functionality.
 * @link https://github.com/googleapis/google-api-php-client/issues/1976
 *
 * Inspired by the following article:
 * @link https://stitcher.io/blog/preloading-in-php-74
 *
 * Also, like an alternative to the above, you can use the following preloader:
 * @link https://github.com/Laragear/Preload
 */
class Preloader
{
    private array $ignores = [];

    private static int $count = 0;

    private array $paths;

    private array $fileMap = [];

    // We'll use composer's classmap to easily find which classes to autoload, based on their filename
    private string $autoloadPath = __DIR__ . '/vendor/composer/autoload_classmap.php';

    private bool $debug = false;

    private bool $useRequire = false;

    public function __construct(string ...$paths)
    {
        $this->paths = $paths;
    }

    public function paths(string ...$paths): self
    {
        $this->paths = array_merge($this->paths, $paths);

        return $this;
    }

    public function ignore(string ...$names): self
    {
        $this->ignores = array_merge($this->ignores, $names);

        return $this;
    }

    public function debug(bool $debug): self
    {
        $this->debug = $debug;

        return $this;
    }

    public function useRequire(bool $use): self
    {
        $this->useRequire = $use;

        return $this;
    }

    public function load(): void
    {
        if ($this->useRequire) {
            $classMap = require $this->autoloadPath;

            $this->fileMap = array_flip($classMap);
        }

        // We'll loop over all registered paths and load them one by one
        foreach ($this->paths as $path) {
            $this->loadPath(rtrim($path, '/'));
        }

        $this->log("[Preloader] Preloaded " . self::$count . " classes");
    }

    private function loadPath(string $path): void
    {
        // If the current path is a directory, we'll load all files in it
        if (is_dir($path)) {
            $this->loadDir($path);

            return;
        }

        // Otherwise we'll just load this one file
        $this->loadFile($path);
    }


    private function loadDir(string $path): void
    {
        $handle = opendir($path);

        // We'll loop over all files and directories
        // in the current path,
        // and load them one by one
        while ($file = readdir($handle)) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $this->loadPath("{$path}/{$file}");
        }

        closedir($handle);
    }

    private function loadFile(string $path): void
    {
        // We resolve the classname from composer's autoload mapping
        $class = $this->fileMap[$path] ?? null;

        $this->log("[Preloader] Attempting to load file: {$path}");
        $this->log("[Preloader] Resolved class: " . ($class ?: 'None'));

        if (str_ends_with($path, '.php') === false) {
            $this->log("[Preloader] Ignoring non-php file: {$path}");

            return;
        }

        // And use it to make sure the class shouldn't be ignored
        if ($this->shouldIgnore($class) || $this->shouldIgnore($path)) {
            $this->log("[Preloader] Ignoring file: {$path}");

            return;
        }

        // Finally we require the path, causing all its dependencies to be loaded as well
        try {
            if (\is_file($path) === false || \is_readable($path) === false) {
                $this->log("[Preloader] File not found or not readable: {$path}");

                return;
            }

            if ($this->useRequire) {
                require_once $path;
            } else {
                opcache_compile_file($path);
            }

            self::$count++;
            $this->log("[Preloader] Successfully preloaded `{$class}`");
        } catch (\Throwable $throwable) {
            $this->log("[Preloader] Failed to preload `{$class}`: " . $throwable->getMessage());
        }
    }

    private function shouldIgnore(?string $name): bool
    {
        if ($name === null) {
            $this->log("[Preloader] Ignored due to missing class name");
            return true;
        }

        foreach ($this->ignores as $ignore) {
            if (str_contains($name, $ignore)) {
                $this->log("[Preloader] Ignored: {$name} due to rule: {$ignore}");

                return true;
            }
        }

        return false;
    }

    private function log(string $message): void
    {
        if ($this->debug) {
            echo $message . PHP_EOL;
        }
    }
}

(new Preloader())
    ->paths(__DIR__ . '/vendor/laravel')
    ->ignore(
        LogManager::class,
        File::class,
        UploadedFile::class,
        Carbon::class,
        Choice::class,
        ChoiceQuestion::class,
        'Symfony\\Component\\Console\\Command\\',
        'Illuminate\\Testing\\',
        'Illuminate\\Foundation\\Testing\\',
    )
    ->useRequire(true)
    ->debug(true)
    ->load();
