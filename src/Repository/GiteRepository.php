<?php

namespace App\Repository;

use App\Entity\Gite;
use App\Entity\GiteSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gite>
 *
 * @method Gite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gite[]    findAll()
 * @method Gite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gite::class);
    }

    public function add(Gite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Gite[]
     */
    public function findGiteSearch(GiteSearch $search)
    {
        $query = $this->createQueryBuilder('g'); // alias de la table en parametre obligatoire

        // WHERE g.surface >= surface AND etc
        if($search->getMinSurface())
        {
            $query = $query->andWhere("g.surface >= :minSurface")
                            ->setParameter("minSurface", $search->getMinSurface());
        }

        if($search->getMinChambre())
        {
            $query = $query->andWhere("g.chambre >= :minChambre")
                            ->setParameter("minChambre", $search->getMinChambre());
        }

        if($search->getMinCouchage())
        {
            $query = $query->andWhere("g.couchage >= :minCouchage")
                            ->setParameter("minCouchage", $search->getMinCouchage());
        }
        if($search->getEquipement()->count() > 0){
            $k = 0;
            foreach($search->getEquipement() as $k => $equipement) {
                $k++;
                $query = $query
            ->andWhere(":equipement$k MEMBER OF g.equipements")
            ->setParameter("equipement$k", $equipement);       
            }
        }
        if($search->getRegion()->count() > 0){
            $k = 0;
            foreach($search->getRegion() as $k => $region) {
                $k++;
                $query = $query
            ->andWhere(":region$k MEMBER OF g.region")
            ->setParameter("region$k", $region);       
            }
        }
        if($search->getMaxTarif())
        {
            $query = $query->andWhere("g.tarif <= :maxTarif")
                            ->setParameter("maxTarif", $search->getMaxTarif());
        }

        $query = $query
        // SELECT * FROM Gite g ORDER BY g.id ASC
                    ->orderBy("g.id", "ASC")
                    ->getQuery()
                    ->getResult();

        return $query;
    }

//    /**
//     * @return Gite[] Returns an array of Gite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Gite
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
