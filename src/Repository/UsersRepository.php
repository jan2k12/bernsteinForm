<?php

namespace App\Repository;

use App\Entity\AdminUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminUser::class);
    }


    public function findBySomething($value)
    {
        $user= $this->createQueryBuilder('u')
            ->where('u.username = :value')->setParameter('value', $value)
            ->orWhere('u.email = :value')->setParameter('value', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        return $user;
    }

}
