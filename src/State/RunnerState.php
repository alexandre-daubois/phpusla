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

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
final class RunnerState
{
    public const BLANK_SPACES = 'Blank spaces';

    public const TYPES = [
        self::BLANK_SPACES,
    ];

    private static ?RunnerState $runnerState = null;

    private static array $state;

    private function __construct()
    {
        // This state class is a singleton.
        self::$runnerState = null;
        self::$state = \array_fill_keys(self::TYPES, 0);
    }

    public static function getInstance(): RunnerState
    {
        if (null === self::$runnerState) {
            self::$runnerState = new self();
        }

        return self::$runnerState;
    }

    public function increment(string $type, int $count = 1): void
    {
        self::$state[$type] += $count;
    }

    public function getState(): array
    {
        return self::$state;
    }

    public function reset(): void
    {
        self::$state = \array_fill_keys(self::TYPES, 0);
    }
}
