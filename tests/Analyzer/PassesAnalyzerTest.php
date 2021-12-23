<?php

namespace Tests\Analyzer;

use Analyzer\Pass\BlankSpacesAnalyzerPass;
use Analyzer\PassesAnalyzer;
use PHPUnit\Framework\TestCase;
use State\AnalyzerState;
use Symfony\Component\Finder\SplFileInfo;

class PassesAnalyzerTest extends TestCase
{
    public function testRegisterPassActuallyAddsIt(): void
    {
        $analyzer = new PassesAnalyzer(new AnalyzerState());
        $analyzer->registerPass(new BlankSpacesAnalyzerPass());

        $this->assertCount(1, $analyzer->getPasses());
        $this->assertInstanceOf(BlankSpacesAnalyzerPass::class, \current($analyzer->getPasses()));
    }

    public function testRegisteredPassActuallyPassesOnFile(): void
    {
        $analyzer = new PassesAnalyzer(new AnalyzerState());

        $pass = $this->createMock(BlankSpacesAnalyzerPass::class);
        $pass->expects($this->once())
            ->method('analyze');

        $analyzer->registerPass($pass);
        $analyzer->analyze($this->createMock(SplFileInfo::class));
    }
}
