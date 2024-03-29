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

namespace Plenta\ContaoCountUpBundle\EventListener\Contao\DataContainer;

use Contao\DataContainer;
use Doctrine\DBAL\Connection;

class CountUpListener
{
    protected Connection $database;
    protected int $decimalPlaces = 0;

    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    public function onValueSaveCallback($value, DataContainer $dc)
    {
        $decimalPlaces = $this->getDecimalPlaces($value);
        $value = $this->stripSeparatorsFromString($value);

        $this->decimalPlaces = $decimalPlaces;

        return $value;
    }

    public function onValueLoadCallback($value, DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;

        if (0 == $activeRecord->plentaCountUpDecimalPlaces) {
            return $value;
        }

        return substr_replace(
            $value,
            $GLOBALS['TL_LANG']['MSC']['decimalSeparator'],
            \strlen($value) - $activeRecord->plentaCountUpDecimalPlaces,
            0
        );
    }

    public function onSubmitCallback(DataContainer $dc): void
    {
        $activeRecord = $dc->activeRecord;

        if ('plenta_countup' === $activeRecord->type) {
            $sql = 'UPDATE tl_content SET plentaCountUpDecimalPlaces=? WHERE id=?';
            $this->database->prepare($sql)->executeStatement([$this->decimalPlaces, $activeRecord->id]);
        }
    }

    public function getDecimalPlaces($value): int
    {
        $decimalSeparator = $GLOBALS['TL_LANG']['MSC']['decimalSeparator'];

        $decimalPosition = strpos($value, $decimalSeparator);

        if (false === $decimalPosition) {
            return 0;
        }

        return \strlen($value) - $decimalPosition - 1;
    }

    public function stripSeparatorsFromString($value)
    {
        $decimalSeparator = $GLOBALS['TL_LANG']['MSC']['decimalSeparator'];
        $thousandsSeparator = $GLOBALS['TL_LANG']['MSC']['thousandsSeparator'];

        $value = str_replace($decimalSeparator, '', $value);

        return str_replace($thousandsSeparator, '', $value);
    }
}
