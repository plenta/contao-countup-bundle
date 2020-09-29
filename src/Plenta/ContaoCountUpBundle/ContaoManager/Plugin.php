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

namespace Plenta\ContaoCountUpBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Plenta\ContaoCountUpBundle\ContaoCountUpBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;

class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoCountUpBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $config)
    {
        $loader->load('@ContaoCountUpBundle/Resources/config/config.yml');
    }
}
