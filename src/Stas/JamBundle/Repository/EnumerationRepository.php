<?php
namespace Stas\JamBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * Repository for enumerations
 */
class EnumerationRepository extends EntityRepository
{
    /**
     * Returns query object with sorting condition
     *
     * @param string $name  sort column
     * @param string $order sort order
     *
     * @return QueryBuilder
     */
    public function getSortQuery($name = 'name', $order = 'ASC')
    {
        /** @var EntityRepository $this */
        $queryBuilder = $this->createQueryBuilder('esq')->orderBy('esq.' . $name, $order);

        return $queryBuilder;
    }
}
