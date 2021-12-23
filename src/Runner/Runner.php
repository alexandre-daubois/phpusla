<?php

/*
 * This file is part of PHPUsla.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Runner;

use Analyzer\Pass\ClassesAnalyzerPass;
use Analyzer\Pass\EndOfFileNewLineAnalyzerPass;
use Analyzer\Pass\QuotesAnalyzerPass;
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

        $state = new AnalyzerState();
        $analyzer = new PassesAnalyzer($state);

        self::registerAnalyzerPasses($analyzer);

        $results = $finder->find();
        $filesCount = $results->count();
        $output->writeln(\sprintf("Found %d files.", $filesCount));
        $state->increment(AnalyzerState::TOTAL_FILES, $filesCount);

        $progressBar = new ProgressBar($output, $filesCount);

        /** @var SplFileInfo $file */
        foreach ($results->getIterator() as $file) {
            $analyzer->analyze($file);
            $progressBar->advance();
        }

        $progressBar->finish();
        $output->writeln("\nFinished the work! Here are the useless results:");

        $state->prettyPrint($output);

        return Command::SUCCESS;
    }

    private static function registerAnalyzerPasses(AnalyzerInterface $analyzer): void
    {
        $analyzer
            ->registerPass(new TotalCharsAnalyzerPass())
            ->registerPass(new BlankSpacesAnalyzerPass())
            ->registerPass(new ClassesAnalyzerPass())
            ->registerPass(new EndOfFileNewLineAnalyzerPass())
            ->registerPass(new QuotesAnalyzerPass())
        ;
    }
}
