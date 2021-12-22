<?php

/*
 * This file is part of IfYouSaySo.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Finder;

use Symfony\Component\Finder\Finder;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
class AbstractFinder implements FinderInterface
{
    protected string $rootDirectory;

    protected array $extensions;

    public function __construct(string $rootDirectory, string|array $extensions)
    {
        $this->rootDirectory = $rootDirectory;

        if (\is_string($extensions)) {
            $extensions = [$extensions];
        }

        $this->extensions = $extensions;
    }

    public function find(): Finder
    {
        return (new Finder())
            ->in($this->rootDirectory)
            ->files()
            ->ignoreUnreadableDirs(true)
            ->name(\array_map(static fn ($extension) => '*'.$extension, $this->extensions));
    }
}
