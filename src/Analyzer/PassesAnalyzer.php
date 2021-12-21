<?php

/*
 * This file is part of IfYouSaySo.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Analyzer;

use Analyzer\Pass\AnalyzerPassInterface;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
final class PassesAnalyzer implements AnalyzerInterface
{
    /**
     * @var AnalyzerPassInterface[]
     */
    protected array $passes = [];

    public function analyze(SplFileInfo $file): void
    {
        foreach ($this->passes as $pass) {
            $pass->pass($file);
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
