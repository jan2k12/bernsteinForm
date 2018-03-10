<?php

namespace App\Repository;

use App\Entity\TurnierForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TurnierFormRepository extends ServiceEntityRepository {
	public function __construct( RegistryInterface $registry ) {
		parent::__construct( $registry, TurnierForm::class );
	}

	public function findTurnierFormWithinGivenDate( $date ) {
		return $this->createQueryBuilder( 'tf' )
		            ->where( 'tf.start_date <= :date' )
		            ->andWhere( 'tf.end_date >= :date' )
		            ->setParameter( 'date', $date )
		            ->getQuery()->execute();
	}

	/*
	public function findBySomething($value)
	{
		return $this->createQueryBuilder('t')
			->where('t.something = :value')->setParameter('value', $value)
			->orderBy('t.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/
}