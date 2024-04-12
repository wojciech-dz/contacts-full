<?php

namespace App\Repository;

use App\Entity\ContactForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactForm>
 *
 * @method ContactForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactForm[]    findAll()
 * @method ContactForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactForm::class);
    }

    /**
     * @return ContactForm[] Returns an array of ContactForm objects
     */
    public function getAllByPage($first, $limit): array
    {
        $query = $this->createQueryBuilder('cf')
            ->orderBy('cf.id', 'ASC')
            ->setFirstResult($first)
            ->setMaxResults($limit)
            ->getQuery();
        $paginator = new Paginator($query);
        $iterator = $paginator->getIterator();

        $arrayCopy = $iterator->getArrayCopy();

        return $arrayCopy;
    }

   /**
    * @return ContactForm[] Returns an array of ContactForm objects
    */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.exampleField = :val')
           ->setParameter('val', $value)
           ->orderBy('c.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getArrayResult()
       ;
   }
}
