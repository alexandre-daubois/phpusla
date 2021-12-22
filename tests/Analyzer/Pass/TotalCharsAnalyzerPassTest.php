<?php

namespace Tests\Analyzer\Pass;

use Analyzer\Pass\TotalCharsAnalyzerPass;
use State\AnalyzerState;

class TotalCharsAnalyzerPassTest extends AnalyzerPassTest
{
    public function testItWorks(): void
    {
        $file = $this->mockSplFileInfoWithContents(\file_get_contents(__DIR__.'/../../Fixtures/blank_spaces.txt'));

        $pass = new TotalCharsAnalyzerPass();
        $pass->analyze($file);

        $this->assertRunnerStateTypeCountSame(AnalyzerState::TOTAL_CHARS, 13);
    }

    public function testWithNoContent(): void
    {
        $file = $this->mockSplFileInfoWithContents('');

        $pass = new TotalCharsAnalyzerPass();
        $pass->analyze($file);

        $this->assertRunnerStateTypeCountSame(AnalyzerState::TOTAL_CHARS, 0);
    }
}
