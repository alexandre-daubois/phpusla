<?php

namespace Tests\Analyzer\Pass;

use Analyzer\Pass\QuotesAnalyzerPass;
use State\AnalyzerState;

class QuotesAnalyzerPassTest extends AnalyzerPassTest
{
    public function testItWorks(): void
    {
        $file = $this->mockSplFileInfoWithContents("'my super test' with \"different' quotes");

        $pass = new QuotesAnalyzerPass();
        $pass->analyze($file);

        $this->assertRunnerStateTypeCountSame(AnalyzerState::SINGLE_QUOTES, 3);
        $this->assertRunnerStateTypeCountSame(AnalyzerState::DOUBLE_QUOTES, 1);
    }
}
