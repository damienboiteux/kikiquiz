<?php

namespace App\Repository;

use App\Entity\Questions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Questions>
 *
 * @method Questions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questions[]    findAll()
 * @method Questions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questions::class);
    }

    public function save(Questions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Questions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findQuestionsDisponibles(int $id)
    {
        // ql = questions liées au questionnaire ($id)
        $questions_liees = $this
            ->createQueryBuilder('ql')
            ->select('ql')
            ->join('ql.questionnaires', 'question')
            ->where('question.id = :id');


        // dump($questions_liees->getQuery()->getResult());

        // Toutes les questions moins (-) les questions liées au formulaire ($id)
        $questions_disponibles = $this
            ->createQueryBuilder('qd')
            ->select('qd')
            ->where('qd.id NOT IN (' . $questions_liees->getDQL() . ')')
            ->setParameter('id', $id);

        return $questions_disponibles->getQuery()->getResult();
    }

    public function findByQuestionnaires(int $questionnaire_id, int $offset = 0)
    {
        return $this
            ->createQueryBuilder('q1')
            ->select('q1, q2')
            ->join('q1.questionnaires', 'q2')
            ->where('q2.id = :id')
            ->setMaxResults(1)
            ->setFirstResult($offset)
            ->setParameter('id', $questionnaire_id)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Questions[] Returns an array of Questions objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Questions
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
