<?php

/*
 * This file is part of IfYouSaySo.
 *
 * (c) Alexandre Daubois <alex.daubois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace State;

use function Symfony\Component\String\s;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
final class AnalyzerState
{
    public const BLANK_SPACES = 'Blank spaces';
    public const ANONYMOUS_CLASSES_DEFINED = 'Anonymous classes defined';
    public const CLASSES_DEFINED = 'Classes defined';
    public const END_OF_FILE_NEW_LINE = 'File finishing with a new line';

    public const TYPES = [
        self::BLANK_SPACES,
        self::CLASSES_DEFINED,
        self::ANONYMOUS_CLASSES_DEFINED,
        self::END_OF_FILE_NEW_LINE,
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

    public function reset(): void
    {
        self::$state = \array_fill_keys(self::TYPES, [
            'count' => 0,
            'extra' => [],
        ]);
    }

    public function prettyPrint(int $totalFiles): void
    {

    }
}
