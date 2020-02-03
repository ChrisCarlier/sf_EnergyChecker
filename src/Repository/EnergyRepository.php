<?php

namespace App\Repository;

use App\Entity\Energy;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            ->distinct('p.year');

//        $query = $this->entityManager->createQuery(
//            'SELECT distinct year
//            FROM App\Entity\Energy e'
//        );
        $query = $queryBuilder->getQuery();
        dump($query->execute());
        return $query->execute();
    }


}
