<?php

/*
 * This file is part of PHPUsla.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace State;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
final class AnalyzerState
{
    public const BLANK_SPACES = 'Blank spaces';
    public const TOTAL_CHARS = 'Total characters';

    public const ANONYMOUS_CLASSES_DEFINED = 'Anonymous classes defined';
    public const CLASSES_DEFINED = 'Classes defined';

    public const END_OF_FILE_NEW_LINE = 'Files finishing with a new line';

    public const DOUBLE_QUOTES = 'Double quotes';
    public const SINGLE_QUOTES = 'Single quotes';

    public const TYPES = [
        self::BLANK_SPACES,
        self::CLASSES_DEFINED,
        self::ANONYMOUS_CLASSES_DEFINED,
        self::END_OF_FILE_NEW_LINE,
        self::TOTAL_CHARS,
        self::DOUBLE_QUOTES,
        self::SINGLE_QUOTES,
    ];

    private static ?AnalyzerState $runnerState = null;

    private static array $state;

    private function __construct()
    {
        // This state class is a singleton.
        self::$runnerState = null;
        self::$state = \array_fill_keys(self::TYPES, [
            'count' => 0,
            'extra' => [],
        ]);
    }

    public static function getInstance(): AnalyzerState
    {
        if (null === self::$runnerState) {
            self::$runnerState = new self();
        }

        return self::$runnerState;
    }

    public function increment(string $type, int $count = 1): void
    {
        self::$state[$type]['count'] += $count;
    }

    public function setExtra(string $type, array $data): void
    {
        self::$state[$type]['extra'] = $data;
    }

    public function getState(): array
    {
        return self::$state;
    }

    public function getTypeCount(string $type): int
    {
        return self::$state[$type]['count'];
    }

    public function reset(): void
    {
        self::$state = \array_fill_keys(self::TYPES, [
            'count' => 0,
            'extra' => [],
        ]);
    }

    public function prettyPrint(OutputInterface $output, int $totalFiles): void
    {
        $table = new Table($output);
        $table->setHeaders(['What', 'How much', 'Any comment?']);
        $table->setRows([
            $this->getRowByType(self::TOTAL_CHARS),
            $this->getRowByType(self::BLANK_SPACES, comment: static function () {
                return \sprintf("That's ~%d%% of total characters, what a waste.",
                    self::getInstance()->getTypeCount(self::BLANK_SPACES)/self::getInstance()->getTypeCount(self::TOTAL_CHARS)*100.0);
            }),
            new TableSeparator(),
            $this->getRowByType(self::CLASSES_DEFINED),
            $this->getRowByType(self::ANONYMOUS_CLASSES_DEFINED, comment: static function () {
                return \sprintf("Around %d%% of total classes, who knows about anonymous classes anyway?",
                    self::getInstance()->getTypeCount(self::ANONYMOUS_CLASSES_DEFINED)/self::getInstance()->getTypeCount(self::CLASSES_DEFINED)*100.0);
            }),
            new TableSeparator(),
            $this->getRowByType(self::END_OF_FILE_NEW_LINE, comment: static function () use ($totalFiles) {
                return \sprintf("This leaves %d files without newline at their end.", $totalFiles - self::getInstance()->getTypeCount(self::END_OF_FILE_NEW_LINE));
            }),
            new TableSeparator(),
            $this->getRowByType("Quotes",
                static function () {
                    return \sprintf('%d single quotes, %d double quotes',
                        self::getInstance()->getTypeCount(self::SINGLE_QUOTES),
                        self::getInstance()->getTypeCount(self::DOUBLE_QUOTES),
                    );
                },
                static function () {
                $singleQuotes = self::getInstance()->getTypeCount(self::SINGLE_QUOTES);
                $doubleQuotes = self::getInstance()->getTypeCount(self::DOUBLE_QUOTES);

                if ($singleQuotes > $doubleQuotes) {
                    return \sprintf("%.2fx more single than double quotes.", $singleQuotes/$doubleQuotes);
                } elseif ($singleQuotes < $doubleQuotes) {
                    return \sprintf("%.2fx less single than double quotes.", $doubleQuotes/$singleQuotes);
                }

                return \sprintf("Single ou double quotes are equally distributed, %d each!", $singleQuotes);
            }),
        ]);

        $table->render();
    }

    private function getRowByType(string $type, callable $value = null, callable $comment = null): array
    {
        return [
            $type,
            $value ? $value() : self::getInstance()->getTypeCount($type),
            $comment ? $comment() : '',
        ];
    }
}
