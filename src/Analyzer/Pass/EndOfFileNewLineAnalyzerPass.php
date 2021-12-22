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
class EndOfFileNewLineAnalyzerPass implements AnalyzerPassInterface
{
    public function analyze(SplFileInfo $file): void
    {
        $content = $file->getContents();

        if ("\n" === $content[\strlen($content)-1]) {
            AnalyzerState::getInstance()->increment(AnalyzerState::END_OF_FILE_NEW_LINE);
        }
    }
}
