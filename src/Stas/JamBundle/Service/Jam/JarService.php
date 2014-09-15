<?php
namespace Stas\JamBundle\Service\Jam;

use Doctrine\ORM\EntityManager;
use Stas\JamBundle\Entity\Jam\Jar;
use Stas\JamBundle\Utils\CloneFactory;

/**
 * Service for Jar entity
 */
class JarService
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var CloneFactory */
    protected $cloneFactory;

    /**
     * @param EntityManager $entityManager
     * @param CloneFactory  $factory
     */
    public function __construct(EntityManager $entityManager, CloneFactory $factory)
    {
        $this->entityManager = $entityManager;
        $this->cloneFactory = $factory;
    }

    /**
     * @param Jar     $jar
     * @param integer $amount
     */
    public function multiCreate(Jar $jar, $amount)
    {
        for ($i = 0; $i < $amount; $i++) {
            $this->entityManager->persist($this->cloneFactory->cloneObject($jar));
        }
        $this->entityManager->flush();
    }
}
