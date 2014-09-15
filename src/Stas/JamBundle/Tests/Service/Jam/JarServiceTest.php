<?php

namespace Stas\JamBundle\Tests\Service\Jam;

use Doctrine\ORM\EntityManager;
use Stas\JamBundle\Entity\Jam\Jar;
use Stas\JamBundle\Service\Jam\JarService;
use Stas\JamBundle\Utils\CloneFactory;

/**
 * Test for Stas\JamBundle\Service\Jam\JarService;
 *
 * @group unit
 */
class JarServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var JarService */
    protected $jarService;

    /** @var \PHPUnit_Framework_MockObject_MockObject | Jar */
    protected $jarEntityMock;

    /** @var \PHPUnit_Framework_MockObject_MockObject | CloneFactory */
    protected $cloneFactoryMock;

    /** @var \PHPUnit_Framework_MockObject_MockObject | EntityManager */
    public $entityManagerMock;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->initEntityManagerMock(array('persist', 'flush'));
        $this->jarEntityMock = $this->getMockBuilder('Stas\JamBundle\Entity\Jam\Jar')
            ->getMock();
        $this->cloneFactoryMock = $this->getMockBuilder('Stas\JamBundle\Utils\CloneFactory')
            ->setMethods(array('cloneObject'))
            ->getMock();

        $this->jarService = new JarService($this->entityManagerMock, $this->cloneFactoryMock);
    }

    /**
     * Create Doctrine Entity Manager Mock
     *
     * @param array $methods
     */
    public function initEntityManagerMock(array $methods)
    {
        /** @var \PHPUnit_Framework_TestCase $defiant */
        $defiant = $this;
        $this->entityManagerMock = $defiant->getMockBuilder('\Doctrine\ORM\EntityManager')->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Tear down
     */
    public function tearDown()
    {
        unset($this->jarService);
        unset($this->jarEntityMock);
        unset($this->entityManagerMock);
        unset($this->cloneFactoryMock);
    }

    /**
     * Test for Stas\JamBundle\Service\Jam\JarService::multiCreate
     *
     * @param integer $amount
     * @param integer $expectedAmount
     *
     * @dataProvider multiCreateDataProvider
     */
    public function testMultiCreate($amount, $expectedAmount)
    {
        $this->cloneFactoryMock
            ->expects($this->exactly($expectedAmount))
            ->method('cloneObject')
            ->with($this->jarEntityMock);
        $this->entityManagerMock
            ->expects($this->exactly($expectedAmount))
            ->method('persist');
        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $this->jarService->multiCreate($this->jarEntityMock, $amount);
    }

    /**
     * Data provider for testMultiCreate
     *
     * @return array
     */
    public function multiCreateDataProvider()
    {
        return array(
            'success case 1' => array(
                'amount' => 3,
                'expectedAmount' => 3,
            ),
            'success case 2' => array(
                'amount' => 7,
                'expectedAmount' => 7,
            ),
        );
    }
}
