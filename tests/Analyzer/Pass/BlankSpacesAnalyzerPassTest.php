<?php

namespace Tests\Analyzer\Pass;

use Analyzer\Pass\BlankSpacesAnalyzerPass;
use State\RunnerState;

class BlankSpacesAnalyzerPassTest extends AnalyzerPassTest
{
    public function testItWorks(): void
    {
        $file = $this->mockSplFileInfoWithContents(\file_get_contents(__DIR__.'/../../Fixtures/blank_spaces.txt'));

        $pass = new BlankSpacesAnalyzerPass();
        $pass->pass($file);

        $this->assertRunnerStateTypeSame(RunnerState::BLANK_SPACES, 6);
    }
}
