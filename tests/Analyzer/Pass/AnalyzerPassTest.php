<?php

namespace Tests\Analyzer\Pass;

use PHPUnit\Framework\TestCase;
use State\AnalyzerState;
use Symfony\Component\Finder\SplFileInfo;

abstract class AnalyzerPassTest extends TestCase
{
    protected function mockSplFileInfoWithContents(string $content): SplFileInfo
    {
        $file = $this->createMock(SplFileInfo::class);
        $file->method('getContents')
            ->willReturn($content);

        return $file;
    }
}
