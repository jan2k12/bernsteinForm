<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 18.02.18
 * Time: 16:28
 */

namespace App\Services;


use App\Entity\TurnierForm;
use App\Repository\TurnierFormRepository;
use Doctrine\ORM\EntityManagerInterface;

class FormularService {

	private $em;


	/**
	 * FormularService constructor.
	 */
	public function __construct(EntityManagerInterface $em) {
		$this->em=$em;
	}

	/**
	 * @param \DateTime $dateTime
	 *
	 * @return mixed
	 */
	public function getFormsForDateRange(\DateTime $dateTime) {
		/** @var TurnierFormRepository $turnierRepo */
		$turnierRepo=$this->em->getRepository(TurnierForm::class);
		$turniere=$turnierRepo->findTurnierFormWithinGivenDate($dateTime);
		return $turniere;
	}
}