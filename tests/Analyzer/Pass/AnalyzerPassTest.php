<?php

namespace Tests\Analyzer\Pass;

use PHPUnit\Framework\TestCase;
use State\RunnerState;
use Symfony\Component\Finder\SplFileInfo;

abstract class AnalyzerPassTest extends TestCase
{
    protected function tearDown(): void
    {
        RunnerState::getInstance()->reset();
    }

    protected function assertRunnerStateTypeSame(string $type, int $count): void
    {
        $this->assertSame($count, RunnerState::getInstance()->getState()[$type]);
    }

    protected function mockSplFileInfoWithContents(string $content): SplFileInfo
    {
        $file = $this->createMock(SplFileInfo::class);
        $file->method('getContents')
            ->willReturn($content);

        return $file;
    }
}
