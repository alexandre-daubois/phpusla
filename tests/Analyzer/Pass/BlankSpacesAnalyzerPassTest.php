<?php

namespace Tests\Analyzer\Pass;

use Analyzer\Pass\BlankSpacesAnalyzerPass;
use State\AnalyzerState;

class BlankSpacesAnalyzerPassTest extends AnalyzerPassTest
{
    public function testItWorks(): void
    {
        $file = $this->mockSplFileInfoWithContents(\file_get_contents(__DIR__.'/../../Fixtures/blank_spaces.txt'));
        $state = new AnalyzerState();

        $pass = new BlankSpacesAnalyzerPass();
        $pass->analyze($file, $state);

        $this->assertSame(6, $state->getTypeCount(AnalyzerState::BLANK_SPACES));
    }
}
