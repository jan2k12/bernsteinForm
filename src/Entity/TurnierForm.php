<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TurnierFormRepository")
 */
class TurnierForm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


	/**
	 * @ORM\Column(type="string", length=100)
	 * @var string
	 */
    private $name;

	/**
	 * @ORM\Column(type="datetime",name="start_date")
	 * @var \DateTime
	 */
    private $start_date;

	/**
	 * @ORM\Column(type="datetime",name="end_date")
	 * @var \DateTime
	 */
	private $end_date;

	/**
	 * @ORM\Column(type="integer")
	 * @var \DateTime
	 */
	private $freePlaces;

	/**
	 * @return \DateTime
	 */
	public function getFreePlaces(): \DateTime {
		return $this->freePlaces;
	}

	/**
	 * @param \DateTime $freePlaces
	 */
	public function setFreePlaces( \DateTime $freePlaces ): void {
		$this->freePlaces = $freePlaces;
	}

	/**
	 * @return \DateTime
	 */
	public function getEndDate(): \DateTime {
		return $this->endDate;
	}

	/**
	 * @param \DateTime $endDate
	 */
	public function setEndDate( \DateTime $endDate ): void {
		$this->endDate = $endDate;
	}

	/**
	 * @return \DateTime
	 */
	public function getStartDate(): \DateTime {
		return $this->startDate;
	}

	/**
	 * @param \DateTime $startDate
	 */
	public function setStartDate( \DateTime $startDate ): void {
		$this->startDate = $startDate;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName( string $name ): void {
		$this->name = $name;
	}


}
