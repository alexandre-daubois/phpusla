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
class EndOfFileNewLineAnalyzerPass implements AnalyzerPassInterface
{
    public function analyze(SplFileInfo $file, AnalyzerState $analyzerState): void
    {
        $content = $file->getContents();

        if (\strlen($content) > 0 && "\n" === $content[\strlen($content)-1]) {
            $analyzerState->increment(AnalyzerState::END_OF_FILE_NEW_LINE);
        }
    }
}
