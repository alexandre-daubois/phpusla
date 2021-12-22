<?php

namespace Tests\Analyzer\Pass;

use PHPUnit\Framework\TestCase;
use State\AnalyzerState;
use Symfony\Component\Finder\SplFileInfo;

abstract class AnalyzerPassTest extends TestCase
{
    protected function tearDown(): void
    {
        AnalyzerState::getInstance()->reset();
    }

    protected function assertRunnerStateTypeCountSame(string $type, int $count): void
    {
        $this->assertSame($count, AnalyzerState::getInstance()->getState()[$type]['count']);
    }

    protected function mockSplFileInfoWithContents(string $content): SplFileInfo
    {
        $file = $this->createMock(SplFileInfo::class);
        $file->method('getContents')
            ->willReturn($content);

        return $file;
    }
}
