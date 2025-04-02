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
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Plenta\ContaoCountUpBundle\InsertTag\InsertTag;
use Plenta\ContaoCountUpBundle\NumberFormat\NumberFormat;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(type: self::TYPE, category: 'texts')]
class CountUpElementController extends AbstractContentElementController
{
    public const string TYPE = 'plenta_countup';

    public function __construct(
        protected Packages $packages,
        protected NumberFormat $numberFormat,
        protected InsertTag $insertTag
    ) {
    }

    public function getBoolFromDatabaseValue($value): bool
    {
        if ('1' === $value || 1 === $value) {
            return true;
        }

        return false;
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $modelRow = $model->row();

        if ('' === $template->get('element_html_id')) {
            $template->set('element_html_id', 'countup-'.$model->id.'"');
        }

        $template->set('valueID', 'countup-'.$model->id.'-value');
        $template->set('plentaCountUpPrefix', $modelRow['plentaCountUpPrefix']);
        $template->set('plentaCountUpSuffix', $modelRow['plentaCountUpSuffix']);

        $countUpValue = $modelRow['plentaCountUpValue'];
        $countUpValueStart = $modelRow['plentaCountUpValueStart'];
        $decimalPlaces = $modelRow['plentaCountUpDecimalPlaces'];

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

        $template->set('plentaCountUpValue', $this->numberFormat->formatValue(
            $countUpValue,
            $decimalPlaces,
            null,
            $this->getBoolFromDatabaseValue($modelRow['plentaCountUpUseGrouping'])
        ));

        $startValue = $this->numberFormat->formatValue(
            $countUpValueStart,
            $modelRow['plentaCountUpDecimalPlaces'],
            '.'
        );

        $endValue = $this->numberFormat->formatValue(
            $countUpValue,
            $modelRow['plentaCountUpDecimalPlaces'],
            '.'
        );

        $dataAttributes = [];

        $dataAttributes[] = 'data-duration='.$modelRow['plentaCountUpDuration'];
        $dataAttributes[] = 'data-startval='.$startValue;
        $dataAttributes[] = 'data-endval='.$endValue;
        $dataAttributes[] = 'data-decimalplaces='.$decimalPlaces;
        $dataAttributes[] = 'data-decimal='.$GLOBALS['TL_LANG']['MSC']['decimalSeparator'];
        $dataAttributes[] = 'data-separator='.$GLOBALS['TL_LANG']['MSC']['thousandsSeparator'];
        $dataAttributes[] = 'data-usegrouping='.($this->getBoolFromDatabaseValue($modelRow['plentaCountUpUseGrouping']) ? 'true' : 'false');
        $dataAttributes[] = 'data-useEasing='.($this->getBoolFromDatabaseValue($modelRow['plentaCountUpUseEasing']) ? 'true' : 'false');

        $template->set('dataAttributes', implode(' ', $dataAttributes));

        return $template->getResponse();
    }
}
