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

use Analyzer\Pass\ClassesAnalyzerPass;
use Analyzer\Pass\EndOfFileNewLineAnalyzerPass;
use Analyzer\Pass\TotalCharsAnalyzerPass;
use Analyzer\PassesAnalyzer;
use Analyzer\AnalyzerInterface;
use Analyzer\Pass\BlankSpacesAnalyzerPass;
use Finder\PhpFileFinder;
use State\AnalyzerState;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
final class Runner
{
    public static function main(OutputInterface $output, string $directory): int
    {
        $finder = new PhpFileFinder($directory);
        $analyzer = new PassesAnalyzer();

        self::registerAnalyzerPasses($analyzer);

        $results = $finder->find();
        $output->writeln(\sprintf("Found %d files.", $results->count()));

        $progressBar = new ProgressBar($output, $results->count());

        /** @var SplFileInfo $file */
        foreach ($results->getIterator() as $file) {
            $analyzer->analyze($file);
            $progressBar->advance();
        }

        $progressBar->finish();
        $output->writeln("\nFinished the work! Here are the useless results:");

        AnalyzerState::getInstance()->prettyPrint($output, $results->count());

        return Command::SUCCESS;
    }

    private static function registerAnalyzerPasses(AnalyzerInterface $analyzer): void
    {
        $analyzer
            ->registerPass(new TotalCharsAnalyzerPass())
            ->registerPass(new BlankSpacesAnalyzerPass())
            ->registerPass(new ClassesAnalyzerPass())
            ->registerPass(new EndOfFileNewLineAnalyzerPass());
    }
}
