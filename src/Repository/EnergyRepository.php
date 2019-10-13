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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Energy::class);
    }


}
