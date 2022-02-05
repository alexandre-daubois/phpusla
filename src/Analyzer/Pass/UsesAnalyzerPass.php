<?php

/*
 * This file is part of PHPUsla.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Analyzer\Pass;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use State\AnalyzerState;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
class UsesAnalyzerPass extends AbstractASTAnalyzerPass
{
    protected function analyzeAST(array $ast, AnalyzerState $analyzerState, string $filename): void
    {
        $useCalls = 0;
        $currentMaxUse = $analyzerState->getTypeCount(AnalyzerState::MAX_USE_CALL_PER_FILE);

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new class($useCalls) extends NodeVisitorAbstract {
            private int $useCalls;

            public function __construct(int &$useCalls)
            {
                $this->useCalls = &$useCalls;
            }

            public function enterNode(Node $node) {
                if (!$node instanceof Node\Stmt\Use_) {
                    return;
                }

                $this->useCalls++;
            }
        });

        $traverser->traverse($ast);

        $analyzerState->increment(AnalyzerState::USE_CALLS, $useCalls);

        if ($currentMaxUse < $useCalls) {
            $analyzerState->set(AnalyzerState::MAX_USE_CALL_PER_FILE, $useCalls);
            $analyzerState->setExtra(AnalyzerState::MAX_USE_CALL_PER_FILE, ['filename' => $filename]);
        }
    }
}
