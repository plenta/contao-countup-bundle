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

namespace Plenta\ContaoCountUpBundle\InsertTag;


use Contao\Controller;
use Contao\CoreBundle\Framework\ContaoFramework;

class InsertTag
{
    protected ContaoFramework $framework;
    public function __construct(
        ContaoFramework $framework
    ) {
        $this->framework = $framework;
    }

    public function isInsertTag(string $value): bool
    {
        $openPos = strpos($value, '{{');
        $closePos = strpos($value, '}}');

        return $openPos !== false && $closePos !== false && $openPos < $closePos;
    }

    public function replaceInsertTag(string $value): string
    {
        $controller = $this->framework->getAdapter(Controller::class);

        return $controller->replaceInsertTags($value);
    }
}
