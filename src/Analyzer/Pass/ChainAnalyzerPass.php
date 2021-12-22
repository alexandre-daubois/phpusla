<?php

/*
 * This file is part of IfYouSaySo.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Analyzer\Pass;

use State\AnalyzerState;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
class ChainAnalyzerPass implements AnalyzerPassInterface
{
    /**
     * @var AnalyzerPassInterface[]
     */
    private array $passes;

    public function __construct(array $passes)
    {
        $this->passes = $passes;
    }

    public function analyze(SplFileInfo $file): void
    {
        foreach ($this->passes as $pass) {
            $pass->analyze($file);
        }
    }

    public function addPass(AnalyzerPassInterface $pass): ChainAnalyzerPass
    {
        $this->passes[] = $pass;

        return $this;
    }
}
