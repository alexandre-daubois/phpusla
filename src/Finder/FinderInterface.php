<?php

/*
 * This file is part of PHPUsla.
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
interface FinderInterface
{
    public function find(): Finder;
}
