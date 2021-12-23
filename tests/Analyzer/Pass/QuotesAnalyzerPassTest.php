<?php

namespace Tests\Analyzer\Pass;

use Analyzer\Pass\QuotesAnalyzerPass;
use State\AnalyzerState;

class QuotesAnalyzerPassTest extends AnalyzerPassTest
{
    public function testItWorks(): void
    {
        $file = $this->mockSplFileInfoWithContents("'my super test' with \"different' quotes");
        $state = new AnalyzerState();

        $pass = new QuotesAnalyzerPass();
        $pass->analyze($file, $state);

        $this->assertSame(3, $state->getTypeCount(AnalyzerState::SINGLE_QUOTES));
        $this->assertSame(1, $state->getTypeCount(AnalyzerState::DOUBLE_QUOTES));
    }
}
