<?php

namespace App\Repository;

use App\Entity\Teilnehmer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TeilnehmerRepository extends ServiceEntityRepository {
	public function __construct( RegistryInterface $registry ) {
		parent::__construct( $registry, Teilnehmer::class );
	}


	public function findByTurnierId( $turnierId ) {
		return $this->createQueryBuilder( 't' )
					->join('t.turnier','tu')
					->addSelect('tu')
		            ->where( 'tu.id = :value' )->setParameter( 'value', $turnierId )
		            ->getQuery()
		            ->getResult();
	}

	public function findByPaidTurnierId($turnierId){
		return $this->createQueryBuilder( 't' )
		            ->join('t.turnier','tu')
		            ->addSelect('tu')
		            ->where( 'tu.id = :value' )->setParameter( 'value', $turnierId )
					->andWhere('t.hasPaid = 1')
		            ->getQuery()
		            ->getResult();
	}

}
