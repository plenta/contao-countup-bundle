<?php

declare(strict_types=1);

/**
 * Count up element for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023, Christian Barkowsky & Christoph Werner
 * @author        Christoph Werner <https://plenta.io>
 * @author        Christian Barkowsky <https://plenta.io>
 * @link          https://plenta.io
 * @license       MIT
 */

namespace Unit\Plenta\ContaoCountUpBundle\NumberFormat;

use PHPUnit\Framework\TestCase;
use Plenta\ContaoCountUpBundle\NumberFormat\NumberFormat;

class NumberFormatTest extends TestCase
{
    protected NumberFormat $testSubject;

    protected function setUp(): void
    {
        $this->testSubject = new NumberFormat();
        $GLOBALS['TL_LANG']['MSC']['decimalSeparator'] = ',';
        $GLOBALS['TL_LANG']['MSC']['thousandsSeparator'] = '.';
    }

    public function testFormatValue(): void
    {
        $data = [
            [
                'value' => '',
                'decimalPlaces' => '2',
                'decimalSeparator' => null,
                'useGrouping' => false,
                'thousandsSeparator' => null,
                'return' => '',
            ],
            [
                'value' => '0',
                'decimalPlaces' => 0,
                'decimalSeparator' => null,
                'useGrouping' => false,
                'thousandsSeparator' => null,
                'return' => '0',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => '2',
                'decimalSeparator' => null,
                'useGrouping' => false,
                'thousandsSeparator' => null,
                'return' => '10000,00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => 2,
                'decimalSeparator' => null,
                'useGrouping' => false,
                'thousandsSeparator' => null,
                'return' => '10000,00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => '2',
                'decimalSeparator' => 'a',
                'useGrouping' => false,
                'thousandsSeparator' => null,
                'return' => '10000a00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => 2,
                'decimalSeparator' => 'a',
                'useGrouping' => false,
                'thousandsSeparator' => null,
                'return' => '10000a00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => '2',
                'decimalSeparator' => null,
                'useGrouping' => true,
                'thousandsSeparator' => null,
                'return' => '10.000,00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => 2,
                'decimalSeparator' => null,
                'useGrouping' => true,
                'thousandsSeparator' => null,
                'return' => '10.000,00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => '2',
                'decimalSeparator' => 'a',
                'useGrouping' => true,
                'thousandsSeparator' => null,
                'return' => '10.000a00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => 2,
                'decimalSeparator' => 'a',
                'useGrouping' => true,
                'thousandsSeparator' => null,
                'return' => '10.000a00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => '2',
                'decimalSeparator' => null,
                'useGrouping' => false,
                'thousandsSeparator' => 'b',
                'return' => '10000,00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => 2,
                'decimalSeparator' => null,
                'useGrouping' => false,
                'thousandsSeparator' => 'b',
                'return' => '10000,00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => '2',
                'decimalSeparator' => 'a',
                'useGrouping' => false,
                'thousandsSeparator' => 'b',
                'return' => '10000a00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => 2,
                'decimalSeparator' => 'a',
                'useGrouping' => false,
                'thousandsSeparator' => 'b',
                'return' => '10000a00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => '2',
                'decimalSeparator' => null,
                'useGrouping' => true,
                'thousandsSeparator' => 'b',
                'return' => '10b000,00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => 2,
                'decimalSeparator' => null,
                'useGrouping' => true,
                'thousandsSeparator' => 'b',
                'return' => '10b000,00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => '2',
                'decimalSeparator' => 'a',
                'useGrouping' => true,
                'thousandsSeparator' => 'b',
                'return' => '10b000a00',
            ],
            [
                'value' => '1000000',
                'decimalPlaces' => 2,
                'decimalSeparator' => 'a',
                'useGrouping' => true,
                'thousandsSeparator' => 'b',
                'return' => '10b000a00',
            ],
        ];

        foreach ($data as $k => $test) {
            $this->assertSame(
                $test['return'],
                $this->testSubject->formatValue(
                    $test['value'],
                    $test['decimalPlaces'],
                    $test['decimalSeparator'],
                    $test['useGrouping'],
                    $test['thousandsSeparator']
                ),
                'Failed at array key '.(string) $k.'.'
            );
        }
    }
}
