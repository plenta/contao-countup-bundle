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

namespace Unit\Plenta\ContaoCountUpBundle\EventListener\Contao\DataContainer;

use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Plenta\ContaoCountUpBundle\EventListener\Contao\DataContainer\CountUpListener;

class CountUpListenerTest extends TestCase
{
    /**
     * @var CountUpListener
     */
    protected $testSubject;

    /**
     * @var DataContainer
     */
    protected $dataContainer;

    protected function setUp(): void
    {
        $this->testSubject = new CountUpListener(
            $this->createMock(Connection::class)
        );

        $this->dataContainer = $this->createMock(DataContainer::class);
    }

    public function testGetDecimalPlaces(): void
    {
        $GLOBALS['TL_LANG']['MSC']['decimalSeparator'] = ',';

        $this->assertSame($this->testSubject->getDecimalPlaces('1000,00'), 2);
        $this->assertSame($this->testSubject->getDecimalPlaces('1000,0'), 1);
        $this->assertSame($this->testSubject->getDecimalPlaces('1000'), 0);
        $this->assertSame($this->testSubject->getDecimalPlaces('1000.00'), 0);

        $GLOBALS['TL_LANG']['MSC']['decimalSeparator'] = '.';

        $this->assertSame($this->testSubject->getDecimalPlaces('1000.00'), 2);
    }

    public function testStripSeparatorsFromString(): void
    {
        $GLOBALS['TL_LANG']['MSC']['decimalSeparator'] = ',';
        $GLOBALS['TL_LANG']['MSC']['thousandsSeparator'] = '.';

        $this->assertSame($this->testSubject->stripSeparatorsFromString('1.000,33'), '100033');
        $this->assertSame($this->testSubject->stripSeparatorsFromString('100033'), '100033');
    }
}
