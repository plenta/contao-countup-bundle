<?php

declare(strict_types=1);

/**
 * Count up element for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2021, Christian Barkowsky & Christoph Werner
 * @author        Christoph Werner <https://plenta.io>
 * @author        Christian Barkowsky <https://plenta.io>
 * @link          https://plenta.io
 * @license       MIT
 */

namespace Plenta\ContaoCountUpBundle\Controller\Contao\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\Template;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CountUpElementController extends AbstractContentElementController
{
    protected Packages $packages;

    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    public function formatValue(
        $value,
        $decimalPlaces,
        $decimalSeparator = null,
        bool $useGrouping = false,
        ?string $thousandsSeparator = null
    ) {
        if (null === $decimalSeparator) {
            $decimalSeparator = $GLOBALS['TL_LANG']['MSC']['decimalSeparator'];
        }

        if (null === $thousandsSeparator) {
            $thousandsSeparator = $GLOBALS['TL_LANG']['MSC']['thousandsSeparator'];
        }

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
            $valueFloat = floatval($this->formatValue($value, $decimalPlaces, '.'));

            return number_format($valueFloat, $decimalPlaces, $decimalSeparator, $thousandsSeparator);
        }

        return $formattedValue;
    }

    public function useGrouping(ContentModel $model): bool
    {
        if ('1' === $model->plentaCountUpUseGrouping || 1 === $model->plentaCountUpUseGrouping) {
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

        $template->plentaCountUpValue = $this->formatValue(
            $model->plentaCountUpValue,
            $model->plentaCountUpDecimalPlaces,
            null,
            $this->useGrouping($model)
        );

        $startValue = $this->formatValue(
            $model->plentaCountUpValueStart,
            $model->plentaCountUpDecimalPlaces,
            '.'
        );

        $endValue = $this->formatValue(
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
        $dataAttributes[] = 'data-usegrouping='.($this->useGrouping($model) ? 'true' : 'false');

        $template->dataAttributes = implode(' ', $dataAttributes);

        return $template->getResponse();
    }
}
