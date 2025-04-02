<?php

declare(strict_types=1);

/**
 * Count up element for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2025, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://plenta.io
 * @license       MIT
 */

namespace Plenta\ContaoCountUpBundle\EventListener\Contao\DataContainer;

use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Plenta\ContaoCountUpBundle\InsertTag\InsertTag;
use Plenta\ContaoCountUpBundle\NumberFormat\NumberFormat;

class CountUpListener
{
    protected Connection $database;
    protected InsertTag $insertTag;
    protected NumberFormat $numberFormat;
    protected int $decimalPlaces = 0;

    public function __construct(
        Connection $database,
        InsertTag $insertTag,
        NumberFormat $numberFormat
    ) {
        $this->database = $database;
        $this->insertTag = $insertTag;
        $this->numberFormat = $numberFormat;
    }

    public function onValueSaveCallback($value, DataContainer $dc)
    {
        if (true === $this->insertTag->isInsertTag($value)) {
            return $value;
        }

        $decimalPlaces = $this->getDecimalPlaces($value);
        $value = $this->stripSeparatorsFromString($value);

        $this->decimalPlaces = $decimalPlaces;

        return $value;
    }

    public function onValueLoadCallback($value, DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;

        if (true === $this->insertTag->isInsertTag($value)) {
            return $value;
        }

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
        return $this->numberFormat->getDecimalPlaces($value, null);
    }

    public function stripSeparatorsFromString($value)
    {
        return $this->numberFormat->stripSeparatorsFromString($value, null, null);
    }
}
