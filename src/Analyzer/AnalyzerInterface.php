<?php

/*
 * This file is part of PHPUsla.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Analyzer;

use Analyzer\Pass\AnalyzerPassInterface;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
interface AnalyzerInterface
{
    public function analyze(SplFileInfo $file): void;

    public function registerPass(AnalyzerPassInterface $analyzerPass): AnalyzerInterface;
}
