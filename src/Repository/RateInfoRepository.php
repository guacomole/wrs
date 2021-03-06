<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\User;
use App\Entity\Task;
use App\Entity\RateInfo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RateInfo::class);
    }


    public function incomingByUserAndTask(User $user, Task $task) : ?Collection
    {
        $res = $this->findBy([
            'user' => $user,
            'task' => $task,
        ]);

        return new ArrayCollection($res);
    }

    public function outcomingByUserAndTask(User $user, Task $task) : ?Collection
    {
        $res = $this->findBy([
            'author' => $user,
            'task' => $task,
        ]);

        return new ArrayCollection($res);
    }


    public function allByUserAndTask(User $user, Task $task) : ?Collection
    {
        $res = $this->findBy([
            'author' => $user,
            'task' => $task,
        ]);

        return new ArrayCollection($res);
    }

    public function allByTask(Task $task): ?Collection
    {
        $res = $this->findBy([
            'task' => $task
        ]);

        return new ArrayCollection($res);
    }

	public function allRatesByParams(User $user, int $value, string $type, array $tasksIds) : ?array
	{
		return $this->createQueryBuilder('r')
			->innerJoin('r.skill', 's', Join::WITH, 's.type = :type')
			->where('r.user = :user')
			->andWhere('r.value = :value')
			->andWhere('s.type = :type')
			->andWhere('r.task IN (:tasksIds)')
			->setParameter('user', $user)
			->setParameter('value', $value)
			->setParameter('type', $type)
			->setParameter('tasksIds', $tasksIds)
			->getQuery()
			->getResult();
	}


    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
