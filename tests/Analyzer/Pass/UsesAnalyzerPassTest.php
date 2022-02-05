<?php

namespace Tests\Analyzer\Pass;

use Analyzer\Pass\UsesAnalyzerPass;
use State\AnalyzerState;

class UsesAnalyzerPassTest extends AnalyzerPassTest
{
    public function testItWorks(): void
    {
        $file = $this->mockSplFileInfoWithContents(\file_get_contents(__DIR__.'/../../Fixtures/Uses.php'), 'Uses.php');
        $state = new AnalyzerState();

        $pass = new UsesAnalyzerPass();
        $pass->analyze($file, $state);

        $this->assertSame(3, $state->getTypeCount(AnalyzerState::USE_CALLS));
        $this->assertSame(3, $state->getTypeCount(AnalyzerState::MAX_USE_CALL_PER_FILE));
        $this->assertSame('Uses.php', $state->getTypeExtra(AnalyzerState::MAX_USE_CALL_PER_FILE)['filename']);
    }
}
