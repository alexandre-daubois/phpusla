<?php

/*
 * This file is part of PHPUsla.
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
class BlankSpacesAnalyzerPass implements AnalyzerPassInterface
{
    public function analyze(SplFileInfo $file): void
    {
        $content = $file->getContents();

        for ($i = 0; $i < \strlen($content); ++$i) {
            if (' ' === $content[$i]) {
                AnalyzerState::getInstance()->increment(AnalyzerState::BLANK_SPACES);
            }
        }
    }
}
