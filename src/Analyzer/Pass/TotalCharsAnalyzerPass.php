<?php

/*
 * This file is part of IfYouSaySo.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Analyzer\Pass;

use State\AnalyzerState;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
class TotalCharsAnalyzerPass implements AnalyzerPassInterface
{
    public function analyze(SplFileInfo $file): void
    {
        AnalyzerState::getInstance()->increment(AnalyzerState::TOTAL_CHARS, \strlen($file->getContents()));
    }
}
