<?php

declare(strict_types=1);

/**
 * Copyright (c) 2018 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/localheinz/phpstan-rules
 */

namespace Localheinz\PHPStan\Rules\Test\Integration\Expressions;

use Localheinz\PHPStan\Rules\Expressions\NoEvalRule;
use Localheinz\PHPStan\Rules\Test\Integration\AbstractTestCase;
use PHPStan\Rules\Rule;

/**
 * @internal
 *
 * @covers \Localheinz\PHPStan\Rules\Expressions\NoEvalRule
 */
final class NoEvalRuleTest extends AbstractTestCase
{
    public function providerAnalysisSucceeds(): iterable
    {
        $paths = [
            'eval-not-used' => __DIR__ . '/../../Fixture/Expressions/NoEvalRule/Success/eval-not-used.php',
        ];

        foreach ($paths as $description => $path) {
            yield $description => [
                $path,
            ];
        }
    }

    public function providerAnalysisFails(): iterable
    {
        $paths = [
            'eval-used-with-correct-case' => [
                __DIR__ . '/../../Fixture/Expressions/NoEvalRule/Failure/eval-used-with-correct-case.php',
                [
                    'Language construct eval() should not be used.',
                    7,
                ],
            ],
            'eval-used-with-incorrect-case' => [
                __DIR__ . '/../../Fixture/Expressions/NoEvalRule/Failure/eval-used-with-incorrect-case.php',
                [
                    'Language construct eval() should not be used.',
                    7,
                ],
            ],
        ];

        foreach ($paths as $description => [$path, $error]) {
            yield $description => [
                $path,
                $error,
            ];
        }
    }

    protected function getRule(): Rule
    {
        return new NoEvalRule();
    }
}