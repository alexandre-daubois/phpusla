<?php

namespace Tests\Analyzer\Pass;

use Analyzer\Pass\TotalCharsAnalyzerPass;
use State\AnalyzerState;

class TotalCharsAnalyzerPassTest extends AnalyzerPassTest
{
    public function testItWorks(): void
    {
        $file = $this->mockSplFileInfoWithContents(\file_get_contents(__DIR__.'/../../Fixtures/blank_spaces.txt'));
        $state = new AnalyzerState();

        $pass = new TotalCharsAnalyzerPass();
        $pass->analyze($file, $state);

        $this->assertSame(13, $state->getTypeCount(AnalyzerState::TOTAL_CHARS));

    }

    public function testWithNoContent(): void
    {
        $file = $this->mockSplFileInfoWithContents('');
        $state = new AnalyzerState();

        $pass = new TotalCharsAnalyzerPass();
        $pass->analyze($file, $state);

        $this->assertSame(0, $state->getTypeCount(AnalyzerState::TOTAL_CHARS));
    }
}
