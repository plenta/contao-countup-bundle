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

use Contao\CoreBundle\InsertTag\InsertTagParser;

class InsertTag
{
    public function __construct(
        protected InsertTagParser $insertTagParser
    ) {
    }

    public function isInsertTag(?string $value): bool
    {
        if (null === $value) {
            return false;
        }

        $openPos = strpos($value, '{{');
        $closePos = strpos($value, '}}');

        return $openPos !== false && $closePos !== false && $openPos < $closePos;
    }

    public function replaceInsertTag(string $value): string
    {
        return $this->insertTagParser->replace($value);
    }
}
