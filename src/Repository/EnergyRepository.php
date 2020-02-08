<?php

namespace App\Repository;

use App\Entity\Energy;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Query;

/**
 * @method Energy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Energy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Energy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnergyRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $this->getEntityManager();
        parent::__construct($registry, Energy::class);
    }

    /**
     * @return array
     */
    public function getYears(): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p.year')
            ->orderBy('p.year','asc')
            ->distinct('p.year');

        $query = $queryBuilder->getQuery();

        return array_column($query->getScalarResult(),'year');
    }

    public function findByYear(int $year2): array
    {
        $filteredResult = [];

        $year1 = $year2 - 1;
        $result = $this->queryByYear($year1,$year2);

        foreach($result as $energy)
        {
            if( ($energy->getYear() == $year1 and $energy->getMonth() == 11) or $energy->getYear() == $year2){
                $filteredResult[] = $energy;
            }
        }

        return $filteredResult;
    }

    /**
     * @param int $year1
     * @param int $year2
     * @return Energy[]
     */
    public function queryByYear(int $year1,int $year2) : array
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->where('e.year >= :year1')
            ->andWhere('e.year <= :year2')
            ->setParameter('year1',$year1)
            ->setParameter('year2',$year2)
            ->OrderBy('e.year','asc')
            ->addOrderBy('e.month','asc');

        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
}
