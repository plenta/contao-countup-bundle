<?php

declare(strict_types=1);

/**
 * Count up element for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2020, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://plenta.io>
 * @author        Christoph Werner <https://plenta.io>
 * @link          https://plenta.io
 * @license       MIT
 */

namespace Plenta\ContaoCountUpBundle\Controller\Contao\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\StringUtil;
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

    protected function getResponse(Template $template, ContentModel $model, Request $request): ?Response
    {
        $GLOBALS['TL_BODY'][] = '<script src="'.$this->packages->getUrl('contaocountup/countup.js', 'contaocountup').'" defer ></script>';

        $template->text = $model->text;

        if ('' === $template->cssID) {
            $template->cssID = ' id="countup-'.$model->id.'"';
        }

        $template->valueID = 'countup-'.$model->id.'-value';

        $dataAttriutes = [];

        $dataAttriutes[] = 'data-duration="'.$model->plentaCountUpDuration.'"';
        $dataAttriutes[] = 'data-startval="'.$model->plentaCountUpValueStart.'"';
        $dataAttriutes[] = 'data-decimalplaces="'.$model->plentaCountUpDecimalPlaces.'"';

        $template->dataAttributes = implode(' ', $dataAttriutes);

        return $template->getResponse();
    }
}
