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

use State\RunnerState;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
class BlankSpacesAnalyzerPass implements AnalyzerPassInterface
{
    public function pass(SplFileInfo $file): void
    {
        $content = $file->getContents();

        for ($i = 0; $i < \strlen($content); ++$i) {
            if (' ' === $content[$i]) {
                RunnerState::getInstance()->increment(RunnerState::BLANK_SPACES);
            }
        }
    }
}
