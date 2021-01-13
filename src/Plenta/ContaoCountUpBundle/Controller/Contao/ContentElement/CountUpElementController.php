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
    protected $packages;

    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    public function formatValue($value, $decimalPlaces, $decimalSeparator = null)
    {
        if (null === $decimalSeparator) {
            $decimalSeparator = $GLOBALS['TL_LANG']['MSC']['decimalSeparator'];
        }

        if (0 == $decimalPlaces) {
            $formatedValue = $value;
        } else {
            $formatedValue = substr_replace(
                $value,
                $decimalSeparator,
                \strlen($value) - $decimalPlaces,
                0
            );
        }

        return $formatedValue;
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
            $model->plentaCountUpDecimalPlaces
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

        $dataAttriutes = [];

        $dataAttriutes[] = 'data-duration="'.$model->plentaCountUpDuration.'"';
        $dataAttriutes[] = 'data-startval="'.$startValue.'"';
        $dataAttriutes[] = 'data-endval="'.$endValue.'"';
        $dataAttriutes[] = 'data-decimalplaces="'.$model->plentaCountUpDecimalPlaces.'"';
        $dataAttriutes[] = 'data-decimal="'.$GLOBALS['TL_LANG']['MSC']['decimalSeparator'].'"';
        $dataAttriutes[] = 'data-separator="'.$GLOBALS['TL_LANG']['MSC']['thousandsSeparator'].'"';
        $dataAttriutes[] = 'data-usegrouping='.('1' === $model->plentaCountUpUseGrouping ? 'true' : 'false');

        $template->dataAttributes = implode(' ', $dataAttriutes);

        return $template->getResponse();
    }
}
