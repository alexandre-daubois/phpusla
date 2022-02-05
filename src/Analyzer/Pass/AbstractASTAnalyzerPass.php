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

use PhpParser\Error;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use State\AnalyzerState;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
abstract class AbstractASTAnalyzerPass implements AnalyzerPassInterface
{
    private Parser $parserFactory;
    private const PREFERRED_PHP_VERSION = ParserFactory::PREFER_PHP7;

    public function __construct()
    {
        $this->parserFactory = (new ParserFactory())->create(self::PREFERRED_PHP_VERSION);
    }

    public final function analyze(SplFileInfo $file, AnalyzerState $analyzerState): void
    {
        try {
            $this->analyzeAST($this->parserFactory->parse($file->getContents()), $analyzerState, $file->getFilename());
        } catch (Error $error) {
            // Todo add log?
        }
    }

    protected abstract function analyzeAST(array $ast, AnalyzerState $analyzerState, string $filename): void;
}
