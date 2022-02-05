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
    public const TOTAL_FILES = 'Total files';
    public const BLANK_SPACES = 'Blank spaces';
    public const TOTAL_CHARS = 'Total characters';

    public const USE_CALLS = 'Uses of use';
    public const MAX_USE_CALL_PER_FILE = 'Max use of use in a file';

    public const ANONYMOUS_CLASSES_DEFINED = 'Anonymous classes defined';
    public const CLASSES_DEFINED = 'Classes defined';

    public const END_OF_FILE_NEW_LINE = 'Files finishing with a new line';

    public const DOUBLE_QUOTES = 'Double quotes';
    public const SINGLE_QUOTES = 'Single quotes';

    public const TYPES = [
        self::TOTAL_FILES,
        self::BLANK_SPACES,
        self::CLASSES_DEFINED,
        self::ANONYMOUS_CLASSES_DEFINED,
        self::END_OF_FILE_NEW_LINE,
        self::TOTAL_CHARS,
        self::DOUBLE_QUOTES,
        self::SINGLE_QUOTES,
        self::USE_CALLS,
        self::MAX_USE_CALL_PER_FILE,
    ];

    private array $state;

    public function __construct()
    {
        $this->state = \array_fill_keys(self::TYPES, [
            'count' => 0,
            'extra' => [],
        ]);
    }

    public function increment(string $type, int $count = 1): void
    {
        $this->state[$type]['count'] += $count;
    }

    public function set(string $type, int $value): void
    {
        $this->state[$type]['count'] = $value;
    }

    public function setExtra(string $type, array $data): void
    {
        $this->state[$type]['extra'] = $data;
    }

    public function getState(): array
    {
        return $this->state;
    }

    public function getTypeCount(string $type): int
    {
        return $this->state[$type]['count'];
    }

    public function getTypeExtra(string $type): array
    {
        return $this->state[$type]['extra'];
    }

    public function reset(): void
    {
        $this->state = \array_fill_keys(self::TYPES, [
            'count' => 0,
            'extra' => [],
        ]);
    }

    public function prettyPrint(OutputInterface $output): void
    {
        $table = new Table($output);
        $table->setHeaders(['What', 'How much', 'Any comment?']);
        $table->setRows([
            $this->getRowByType(self::TOTAL_CHARS),
            $this->getRowByType(self::BLANK_SPACES, comment: function () {
                return \sprintf("That's ~%d%% of total characters, what a waste.",
                    $this->getTypeCount(self::BLANK_SPACES)/$this->getTypeCount(self::TOTAL_CHARS)*100.0);
            }),
            new TableSeparator(),
            $this->getRowByType(self::CLASSES_DEFINED),
            $this->getRowByType(self::ANONYMOUS_CLASSES_DEFINED, comment: function () {
                return \sprintf("Around %d%% of total classes, who knows about anonymous classes anyway?",
                    $this->getTypeCount(self::ANONYMOUS_CLASSES_DEFINED)/$this->getTypeCount(self::CLASSES_DEFINED)*100.0);
            }),
            new TableSeparator(),
            $this->getRowByType(self::END_OF_FILE_NEW_LINE, comment: function () {
                return \sprintf("This leaves %d files without newline at their end.", $this->getTypeCount(self::TOTAL_FILES) - $this->getTypeCount(self::END_OF_FILE_NEW_LINE));
            }),
            new TableSeparator(),
            $this->getRowByType("Quotes",
                function () {
                    return \sprintf('%d single quotes, %d double quotes',
                        $this->getTypeCount(self::SINGLE_QUOTES),
                        $this->getTypeCount(self::DOUBLE_QUOTES),
                    );
                },
                function () {
                    $singleQuotes = $this->getTypeCount(self::SINGLE_QUOTES);
                    $doubleQuotes = $this->getTypeCount(self::DOUBLE_QUOTES);

                    if ($singleQuotes > $doubleQuotes) {
                        return \sprintf("%.2fx more single than double quotes.", $singleQuotes/$doubleQuotes);
                    } elseif ($singleQuotes < $doubleQuotes) {
                        return \sprintf("%.2fx less single than double quotes.", $doubleQuotes/$singleQuotes);
                    }

                    return \sprintf("Single ou double quotes are equally distributed, %d each!", $singleQuotes);
                }
            ),
            new TableSeparator(),
            $this->getRowByType(self::USE_CALLS),
            $this->getRowByType(self::MAX_USE_CALL_PER_FILE, comment: function () {
                return \sprintf('The big winner of this category is %s.', $this->getTypeExtra(self::MAX_USE_CALL_PER_FILE)['filename']);
            }),
        ]);

        $table->render();
    }

    private function getRowByType(string $type, callable $value = null, callable $comment = null): array
    {
        return [
            $type,
            $value ? $value() : $this->getTypeCount($type),
            $comment ? $comment() : '',
        ];
    }
}
