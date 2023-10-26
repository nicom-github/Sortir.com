<?php

namespace App\Repository;

use App\data\SearchData;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use http\Client\Curl\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);

    }

    public function add(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function findSortie(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function findSearch(SearchData $search,Participant $user): array
    {
        $query = $this
            ->createQueryBuilder('s')
            ->join('s.etat','e')
            ->addSelect('e')
            ->orderBy('s.id', 'ASC');

        //Recherche par Campus
        if (!empty($search->campus)) {
            $query = $query
                ->andWhere('s.campus IN (:campus)')
                ->setParameter('campus', $search->campus);
        }

        //Recherche par nom de sortie
        if (!empty($search->sortieNom)) {
            $query = $query
                ->andWhere('s.nom LIKE :sortieNom')
                ->setParameter('sortieNom', "%{$search->sortieNom}%");
        }

        //Recherche par date (Start Date)
        if (!empty($search->dateDebut)) {
            $query = $query
                ->andWhere('s.dateHeureDebut > :dateStart')
                ->setParameter('dateStart', $search->dateDebut);
        }
        //Recherche par date (Stop Date)
        if (!empty($search->dateFin)) {
            $query = $query
                ->andWhere('s.dateHeureDebut < :dateStop')
                ->setParameter('dateStop', $search->dateFin);
        }


        //Recherche les sorties dont je suis organisateur
        if (!empty($search->isOrganisateur)) {

            $query = $query
                ->andWhere('s.organisateur = :user')
                ->setParameter('user',$user)
            ;
        }

        //Recherche les sorties auquels je suis inscrit
        if (!empty($search->isInscrit)) {
            $query = $query
                ->andWhere(':user MEMBER OF s.participants')
            ->setParameter('user',$user);

        }

        //Recherche les sorties auquels je ne suis pas inscrit
        if (!empty($search->isNotInscrit)) {
            $query = $query
                ->andWhere(':user NOT MEMBER OF s.participants')
                ->setParameter('user',$user);

        }

        //Recherche les sorties en statut fini
        if (!empty($search->isSortiesFinie)) {
            $query = $query
                ->andWhere('s.etat = 5');
        }

        return $query
            ->getQuery()
            ->getResult();
    }



//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
