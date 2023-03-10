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

namespace Plenta\ContaoCountUpBundle\Controller\Contao\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\Template;
use Plenta\ContaoCountUpBundle\NumberFormat\NumberFormat;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CountUpElementController extends AbstractContentElementController
{
    protected Packages $packages;
    protected NumberFormat $numberFormat;

    public function __construct(Packages $packages, NumberFormat $numberFormat)
    {
        $this->packages = $packages;
        $this->numberFormat = $numberFormat;
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
        $GLOBALS['TL_BODY'][] = '<script src="'.$this->packages->getUrl('contaocountup/countup.js', 'contaocountup').'" defer ></script>';

        if ('' === $template->cssID) {
            $template->cssID = ' id="countup-'.$model->id.'"';
        }

        $template->valueID = 'countup-'.$model->id.'-value';

        $template->plentaCountUpValue = $this->numberFormat->formatValue(
            $model->plentaCountUpValue,
            $model->plentaCountUpDecimalPlaces,
            null,
            $this->getBoolFromDatabaseValue($model->plentaCountUpUseGrouping)
        );

        $startValue = $this->numberFormat->formatValue(
            $model->plentaCountUpValueStart,
            $model->plentaCountUpDecimalPlaces,
            '.'
        );

        $endValue = $this->numberFormat->formatValue(
            $model->plentaCountUpValue,
            $model->plentaCountUpDecimalPlaces,
            '.'
        );

        $dataAttributes = [];

        $dataAttributes[] = 'data-duration="'.$model->plentaCountUpDuration.'"';
        $dataAttributes[] = 'data-startval="'.$startValue.'"';
        $dataAttributes[] = 'data-endval="'.$endValue.'"';
        $dataAttributes[] = 'data-decimalplaces="'.$model->plentaCountUpDecimalPlaces.'"';
        $dataAttributes[] = 'data-decimal="'.$GLOBALS['TL_LANG']['MSC']['decimalSeparator'].'"';
        $dataAttributes[] = 'data-separator="'.$GLOBALS['TL_LANG']['MSC']['thousandsSeparator'].'"';
        $dataAttributes[] = 'data-usegrouping='.($this->getBoolFromDatabaseValue($model->plentaCountUpUseGrouping) ? 'true' : 'false');
        $dataAttributes[] = 'data-useEasing='.($this->getBoolFromDatabaseValue($model->plentaCountUpUseEasing) ? 'true' : 'false');

        $template->dataAttributes = implode(' ', $dataAttributes);

        return $template->getResponse();
    }
}
