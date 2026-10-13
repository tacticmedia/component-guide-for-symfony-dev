<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests;

use PHPUnit\Framework\Attributes\After;

trait TemporaryDirectory
{
    private ?string $temporaryDirectory = null;

    protected function temporaryDirectory(): string
    {
        if (null === $this->temporaryDirectory) {
            $this->temporaryDirectory = sys_get_temp_dir().'/component-guide-'.bin2hex(random_bytes(6));
            mkdir($this->temporaryDirectory, 0o777, true);
        }

        return $this->temporaryDirectory;
    }

    protected function writeFile(string $relativePath, string $content): string
    {
        $path = $this->temporaryDirectory().'/'.$relativePath;
        if (!is_dir(\dirname($path))) {
            mkdir(\dirname($path), 0o777, true);
        }
        file_put_contents($path, $content);

        return $path;
    }

    #[After]
    protected function removeTemporaryDirectory(): void
    {
        if (null === $this->temporaryDirectory) {
            return;
        }
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->temporaryDirectory, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST,
        );
        foreach ($files as $file) {
            \assert($file instanceof \SplFileInfo);
            $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
        }
        rmdir($this->temporaryDirectory);
        $this->temporaryDirectory = null;
    }
}
