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

namespace Plenta\ContaoCountUpBundle;

use Plenta\ContaoCountUpBundle\DependencyInjection\ContaoCountUpExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class ContaoCountUpBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new ContaoCountUpExtension();
    }
}
