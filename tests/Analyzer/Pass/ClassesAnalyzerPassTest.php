<?php

namespace Tests\Analyzer\Pass;

use Analyzer\Pass\BlankSpacesAnalyzerPass;
use Analyzer\Pass\ClassesAnalyzerPass;
use State\AnalyzerState;

class ClassesAnalyzerPassTest extends AnalyzerPassTest
{
    public function testItWorks(): void
    {
        $file = $this->mockSplFileInfoWithContents(\file_get_contents(__DIR__.'/../../Fixtures/Classes.php'));
        $state = new AnalyzerState();

        $pass = new ClassesAnalyzerPass();
        $pass->analyze($file, $state);

        $this->assertSame(3, $state->getTypeCount(AnalyzerState::CLASSES_DEFINED));
        $this->assertSame(1, $state->getTypeCount(AnalyzerState::ANONYMOUS_CLASSES_DEFINED));
    }
}
