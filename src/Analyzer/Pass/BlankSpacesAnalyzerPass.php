<?php

namespace Analyzer\Pass;

use State\RunnerState;
use Symfony\Component\Finder\SplFileInfo;

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
