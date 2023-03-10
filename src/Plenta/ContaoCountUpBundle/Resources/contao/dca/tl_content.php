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

use Plenta\ContaoCountUpBundle\EventListener\Contao\DataContainer\CountUpListener;

$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = [
    CountUpListener::class, 'onSubmitCallback',
];

$GLOBALS['TL_DCA']['tl_content']['palettes']['plenta_countup'] =
    '{type_legend},type;{countup_legend},plentaCountUpValue,plentaCountUpValueStart,plentaCountUpPrefix,plentaCountUpSuffix,plentaCountUpDuration,plentaCountUpUseGrouping;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop'
;

$GLOBALS['TL_DCA']['tl_content']['fields']['plentaCountUpValue'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['plentaCountUpValue'],
    'exclude' => true,
    'sorting' => true,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
        'mandatory' => true,
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['plentaCountUpValueStart'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['plentaCountUpValueStart'],
    'exclude' => true,
    'sorting' => true,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
        'mandatory' => true,
    ],
    'sql' => "varchar(255) NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['plentaCountUpDuration'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['plentaCountUpDuration'],
    'exclude' => true,
    'sorting' => true,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
        'rgxp' => 'digit',
        'mandatory' => true,
    ],
    'sql' => "varchar(255) NOT NULL default '2'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['plentaCountUpDecimalPlaces'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['plentaCountUpDecimalPlaces'],
    'exclude' => true,
    'sorting' => true,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
        'rgxp' => 'natural',
    ],
    'sql' => [
        'type' => 'integer',
        'default' => 0,
    ],
];

$GLOBALS['TL_DCA']['tl_content']['fields']['plentaCountUpPrefix'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['plentaCountUpPrefix'],
    'exclude' => true,
    'sorting' => true,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['plentaCountUpSuffix'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['plentaCountUpSuffix'],
    'exclude' => true,
    'sorting' => true,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['plentaCountUpUseGrouping'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['plentaCountUpUseGrouping'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'default' => 1,
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => true,
    ],
];
