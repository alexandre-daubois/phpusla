<?php

/*
 * This file is part of IfYouSaySo.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Runner;

use Analyzer\PassesAnalyzer;
use Analyzer\AnalyzerInterface;
use Analyzer\Pass\BlankSpacesAnalyzerPass;
use Finder\PhpFileFinder;
use State\RunnerState;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
final class Runner
{
    public static function main(): void
    {
        if (!isset($_SERVER['argv'][1])) {
            \fwrite(
                \STDERR,
                "You must pass the root directory as the first argument of the command.".\PHP_EOL
            );

            exit(1);
        }

        $finder = new PhpFileFinder($_SERVER['argv'][1]);
        $analyzer = new PassesAnalyzer();

        self::registerAnalyzerPasses($analyzer);

        /** @var SplFileInfo $file */
        foreach ($finder->find() as $file) {
            $analyzer->analyze($file);
        }

        var_dump(RunnerState::getInstance()->getState());
    }

    private static function registerAnalyzerPasses(AnalyzerInterface $analyzer): void
    {
        $analyzer
            ->registerPass(new BlankSpacesAnalyzerPass());
    }
}
