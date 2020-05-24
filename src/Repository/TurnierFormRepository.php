<?php

namespace App\Repository;

use App\Entity\TurnierForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TurnierFormRepository extends ServiceEntityRepository {
	public function __construct( ManagerRegistry $registry ) {
		parent::__construct( $registry, TurnierForm::class );
	}

	public function findTurnierFormWithinGivenDate( $date ) {
		return $this->createQueryBuilder( 'tf' )
		            ->where( 'tf.start_date <= :date' )
		            ->andWhere( 'tf.end_date >= :date' )
		            ->setParameter( 'date', $date )
		            ->getQuery()->execute();
	}

}
