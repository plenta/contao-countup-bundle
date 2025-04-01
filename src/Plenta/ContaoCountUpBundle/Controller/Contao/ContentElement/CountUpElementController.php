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

namespace Plenta\ContaoCountUpBundle\Controller\Contao\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\Template;
use Plenta\ContaoCountUpBundle\InsertTag\InsertTag;
use Plenta\ContaoCountUpBundle\NumberFormat\NumberFormat;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CountUpElementController extends AbstractContentElementController
{
    protected Packages $packages;
    protected NumberFormat $numberFormat;
    protected InsertTag $insertTag;

    public function __construct(
        Packages $packages,
        NumberFormat $numberFormat,
        InsertTag $insertTag
    ){
        $this->packages = $packages;
        $this->numberFormat = $numberFormat;
        $this->insertTag = $insertTag;
    }

    public function getBoolFromDatabaseValue($value)
    {
        if ('1' === $value || 1 === $value) {
            return true;
        }

        return false;
    }

    protected function getResponse(Template $template, ContentModel $model, Request $request): ?Response
    {
        $GLOBALS['TL_BODY']['contao-count-up-js'] = '<script src="'.$this->packages->getUrl('contaocountup/countup.js', 'contaocountup').'" defer ></script>';

        if ('' === $template->cssID) {
            $template->cssID = ' id="countup-'.$model->id.'"';
        }

        $template->valueID = 'countup-'.$model->id.'-value';

        $countUpValue = $model->plentaCountUpValue;
        $countUpValueStart = $model->plentaCountUpValueStart;
        $decimalPlaces = $model->plentaCountUpDecimalPlaces;

        if (true === $this->insertTag->isInsertTag($countUpValue)) {
            $countUpValue = $this->insertTag->replaceInsertTag($countUpValue);
            $decimalPlaces = $this->numberFormat->getDecimalPlaces($countUpValue, '.');
            $countUpValue = $this->numberFormat->stripSeparatorsFromString($countUpValue, '.', ',');
        }

        if (true === $this->insertTag->isInsertTag($countUpValueStart)) {
            $countUpValueStart = $this->insertTag->replaceInsertTag($countUpValueStart);
            $decimalPlaces = $this->numberFormat->getDecimalPlaces($countUpValueStart, '.');
            $countUpValueStart = $this->numberFormat->stripSeparatorsFromString($countUpValueStart, '.', ',');
        }

        $template->plentaCountUpValue = $this->numberFormat->formatValue(
            $countUpValue,
            $decimalPlaces,
            null,
            $this->getBoolFromDatabaseValue($model->plentaCountUpUseGrouping)
        );

        $startValue = $this->numberFormat->formatValue(
            $countUpValueStart,
            $model->plentaCountUpDecimalPlaces,
            '.'
        );

        $endValue = $this->numberFormat->formatValue(
            $countUpValue,
            $model->plentaCountUpDecimalPlaces,
            '.'
        );

        $dataAttributes = [];

        $dataAttributes[] = 'data-duration="'.$model->plentaCountUpDuration.'"';
        $dataAttributes[] = 'data-startval="'.$startValue.'"';
        $dataAttributes[] = 'data-endval="'.$endValue.'"';
        $dataAttributes[] = 'data-decimalplaces="'.$decimalPlaces.'"';
        $dataAttributes[] = 'data-decimal="'.$GLOBALS['TL_LANG']['MSC']['decimalSeparator'].'"';
        $dataAttributes[] = 'data-separator="'.$GLOBALS['TL_LANG']['MSC']['thousandsSeparator'].'"';
        $dataAttributes[] = 'data-usegrouping='.($this->getBoolFromDatabaseValue($model->plentaCountUpUseGrouping) ? 'true' : 'false');
        $dataAttributes[] = 'data-useEasing='.($this->getBoolFromDatabaseValue($model->plentaCountUpUseEasing) ? 'true' : 'false');

        $template->dataAttributes = implode(' ', $dataAttributes);

        return $template->getResponse();
    }
}
