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

        $pass = new ClassesAnalyzerPass();
        $pass->analyze($file);

        $this->assertRunnerStateTypeCountSame(AnalyzerState::CLASSES_DEFINED, 3);
        $this->assertRunnerStateTypeCountSame(AnalyzerState::ANONYMOUS_CLASSES_DEFINED, 1);
    }
}
