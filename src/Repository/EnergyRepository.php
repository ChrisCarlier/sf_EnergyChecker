<?php

namespace App\Repository;

use App\Entity\Energy;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Energy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Energy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Energy[]    findAll()
 * @method Energy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnergyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Energy::class);
    }

    public function findAll() : array
    {
        return $this->createQueryBuilder('e')
                ->getQuery()
                ->getResult();
    }
}
