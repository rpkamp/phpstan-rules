<?php

declare(strict_types=1);

/**
 * Copyright (c) 2018 Andreas Möller.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/localheinz/phpstan-rules
 */

namespace Localheinz\PHPStan\Rules\Test\Integration\Classes;

use Localheinz\PHPStan\Rules\Classes\FinalRule;
use Localheinz\PHPStan\Rules\Test\Fixture;
use Localheinz\PHPStan\Rules\Test\Integration\AbstractTestCase;
use PHPStan\Rules\Rule;

/**
 * @internal
 */
final class FinalRuleTest extends AbstractTestCase
{
    public function providerAnalysisSucceeds(): \Generator
    {
        $paths = [
            'final-class' => __DIR__ . '/../../Fixture/Classes/FinalRule/FinalClass.php',
            'final-class-with-anonymous-class' => __DIR__ . '/../../Fixture/Classes/FinalRule/FinalClassWithAnonymousClass.php',
            'class-neither-abstract-nor-final-but-whitelisted' => __DIR__ . '/../../Fixture/Classes/FinalRule/NeitherAbstractNorFinalClassButWhitelisted.php',
            'interface' => __DIR__ . '/../../Fixture/Classes/FinalRule/ExampleInterface.php',
            'script-with-anonymous-class' => __DIR__ . '/../../Fixture/Classes/FinalRule/script-with-anonymous-class.php',
            'trait' => __DIR__ . '/../../Fixture/Classes/FinalRule/ExampleTrait.php',
            'trait-with-anonymous-class' => __DIR__ . '/../../Fixture/Classes/FinalRule/TraitWithAnonymousClass.php',
        ];

        foreach ($paths as $description => $path) {
            yield $description => [
                $path,
            ];
        }
    }

    public function providerAnalysisFails(): \Generator
    {
        $paths = [
            'abstract-class' => [
                __DIR__ . '/../../Fixture/Classes/FinalRule/NeitherAbstractNorFinalClass.php',
                [
                    \sprintf(
                        'Class "%s" should be marked as final.',
                        Fixture\Classes\FinalRule\NeitherAbstractNorFinalClass::class
                    ),
                    7,
                ],
            ],
            'abstract-class-with-anonymous-class' => [
                __DIR__ . '/../../Fixture/Classes/FinalRule/AbstractClassWithAnonymousClass.php',
                [
                    \sprintf(
                        'Class "%s" should be marked as final.',
                        Fixture\Classes\FinalRule\AbstractClassWithAnonymousClass::class
                    ),
                    7,
                ],
            ],
            'neither-abstract-nor-final-class' => [
                __DIR__ . '/../../Fixture/Classes/FinalRule/NeitherAbstractNorFinalClass.php',
                [
                    \sprintf(
                        'Class "%s" should be marked as final.',
                        Fixture\Classes\FinalRule\NeitherAbstractNorFinalClass::class
                    ),
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
        return new FinalRule([
            Fixture\Classes\FinalRule\NeitherAbstractNorFinalClassButWhitelisted::class,
        ]);
    }
}