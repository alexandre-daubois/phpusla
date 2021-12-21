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

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
final class PhpFileFinder extends AbstractFinder
{
    public function __construct(string $rootDirectory)
    {
        parent::__construct($rootDirectory, ['.php']);
    }
}
