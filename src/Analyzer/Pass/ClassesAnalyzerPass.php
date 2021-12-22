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

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use State\AnalyzerState;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
class ClassesAnalyzerPass extends AbstractASTAnalyzerPass
{
    protected function analyzeAST(array $ast): void
    {
        $analyzeResults = [
            AnalyzerState::ANONYMOUS_CLASSES_DEFINED => 0,
            AnalyzerState::CLASSES_DEFINED => 0,
        ];

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new class($analyzeResults) extends NodeVisitorAbstract {
            private array $analyzeResults;

            public function __construct(array &$analyzerResults)
            {
                $this->analyzeResults = &$analyzerResults;
            }

            public function enterNode(Node $node) {
                if (!$node instanceof Node\Stmt\Class_) {
                    return;
                }

                if ($node->isAnonymous()) {
                    $this->analyzeResults[AnalyzerState::ANONYMOUS_CLASSES_DEFINED]++;
                }

                $this->analyzeResults[AnalyzerState::CLASSES_DEFINED]++;
            }
        });

        $traverser->traverse($ast);
        AnalyzerState::getInstance()->increment(AnalyzerState::ANONYMOUS_CLASSES_DEFINED, $analyzeResults[AnalyzerState::ANONYMOUS_CLASSES_DEFINED]);
        AnalyzerState::getInstance()->increment(AnalyzerState::CLASSES_DEFINED, $analyzeResults[AnalyzerState::CLASSES_DEFINED]);
    }
}
