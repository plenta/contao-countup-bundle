<?php

declare(strict_types=1);

/**
 * Count up element for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://plenta.io
 * @license       MIT
 */

namespace Plenta\ContaoCountUpBundle\NumberFormat;

class NumberFormat
{
    public function formatValue(
        $value,
        $decimalPlaces,
        $decimalSeparator = null,
        bool $useGrouping = false,
        ?string $thousandsSeparator = null
    ): string {
        if ('' === $value) {
            return '';
        }

        if (null === $decimalSeparator) {
            $decimalSeparator = $GLOBALS['TL_LANG']['MSC']['decimalSeparator'];
        }

        if (null === $thousandsSeparator) {
            $thousandsSeparator = $GLOBALS['TL_LANG']['MSC']['thousandsSeparator'];
        }

        $decimalPlaces = (int) $decimalPlaces;

        if (0 == $decimalPlaces) {
            $formattedValue = $value;
        } else {
            $formattedValue = substr_replace(
                $value,
                $decimalSeparator,
                \strlen($value) - $decimalPlaces,
                0
            );
        }

        if (true === $useGrouping) {
            $valueFloat = (float) $this->formatValue($value, $decimalPlaces, '.');

            return number_format($valueFloat, $decimalPlaces, $decimalSeparator, $thousandsSeparator);
        }

        return $formattedValue;
    }
}
