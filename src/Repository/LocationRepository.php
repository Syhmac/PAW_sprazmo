<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function findByCountryAndCity(string $country, string $city): Location {
        $query = $this->createQueryBuilder('l')
            ->where('l.country = :country')
            ->andWhere('l.name = :city')
            ->setParameter('country', $country)
            ->setParameter('city', $city)
            ->getQuery();

        return $query->getResult()[0];
    }
}
