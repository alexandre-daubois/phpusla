<?php

/*
 * This file is part of PHPUsla.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Analyzer;

use Analyzer\Pass\AnalyzerPassInterface;
use State\AnalyzerState;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
final class PassesAnalyzer implements AnalyzerInterface
{
    /**
     * @var AnalyzerPassInterface[]
     */
    private array $passes = [];

    private AnalyzerState $analyzerState;

    public function __construct(AnalyzerState $analyzerState)
    {
        $this->analyzerState = $analyzerState;
    }

    public function analyze(SplFileInfo $file): void
    {
        foreach ($this->passes as $pass) {
            $pass->analyze($file, $this->analyzerState);
        }
    }

    public function registerPass(AnalyzerPassInterface $analyzerPass): AnalyzerInterface
    {
        $this->passes[] = $analyzerPass;

        return $this;
    }

    public function getPasses(): array
    {
        return $this->passes;
    }
}
