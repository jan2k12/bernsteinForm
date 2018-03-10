<?php

namespace App\Repository;

use App\Entity\AdminUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
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
