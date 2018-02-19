<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeilnehmerRepository")
 */
class Teilnehmer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
    private $name;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
    private $prename;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
    private $street;

	/**
	 * @ORM\Column(type="string",length=5)
	 * @var string
	 */
    private $plz;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
    private $city;

	/**
	 * @ORM\Column(type="string",length=2)
	 * @var string
	 */
    private $country;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
    private $email;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Agegroup")
	 * @ORM\JoinColumn(nullable=false)
	 * @var Agegroup
	 */
    private $agegroupe;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Bowclass")
	 * @ORM\JoinColumn(nullable=false)
	 * @var Bowclass
	 */
    private $bowclass;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
    private $society;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\TurnierForm",inversedBy="teilnehmer")
	 * @ORM\JoinColumn(nullable=false)
	 * @var TurnierForm
	 */
    private $turnier;

	/**
	 * @return string
	 */
	public function getName(): ?string {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName( string $name ): void {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getPrename(): ?string {
		return $this->prename;
	}

	/**
	 * @param string $prename
	 */
	public function setPrename( string $prename ): void {
		$this->prename = $prename;
	}

	/**
	 * @return string
	 */
	public function getStreet(): ?string {
		return $this->street;
	}

	/**
	 * @param string $street
	 */
	public function setStreet( string $street ): void {
		$this->street = $street;
	}

	/**
	 * @return string
	 */
	public function getPlz(): ?string {
		return $this->plz;
	}

	/**
	 * @param string $plz
	 */
	public function setPlz( string $plz ): void {
		$this->plz = $plz;
	}

	/**
	 * @return string
	 */
	public function getCity(): ?string {
		return $this->city;
	}

	/**
	 * @param string $city
	 */
	public function setCity( string $city ): void {
		$this->city = $city;
	}

	/**
	 * @return string
	 */
	public function getCountry(): ?string {
		return $this->country;
	}

	/**
	 * @param string $country
	 */
	public function setCountry( string $country ): void {
		$this->country = $country;
	}

	/**
	 * @return string
	 */
	public function getEmail(): ?string {
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail( string $email ): void {
		$this->email = $email;
	}

	/**
	 * @return Agegroup
	 */
	public function getAgegroupe(): ?Agegroup {
		return $this->agegroupe;
	}

	/**
	 * @param Agegroup $agegroupe
	 */
	public function setAgegroupe( Agegroup $agegroupe ): void {
		$this->agegroupe = $agegroupe;
	}

	/**
	 * @return Bowclass
	 */
	public function getBowclass(): ?Bowclass {
		return $this->bowclass;
	}

	/**
	 * @param Bowclass $bowclass
	 */
	public function setBowclass( Bowclass $bowclass ): void {
		$this->bowclass = $bowclass;
	}

	/**
	 * @return string
	 */
	public function getSociety(): ?string {
		return $this->society;
	}

	/**
	 * @param string $society
	 */
	public function setSociety( string $society ): void {
		$this->society = $society;
	}

	/**
	 * @return TurnierForm
	 */
	public function getTurnier(): ?TurnierForm {
		return $this->turnier;
	}

	/**
	 * @param TurnierForm $turnier
	 */
	public function setTurnier( TurnierForm $turnier ): void {
		$this->turnier = $turnier;
	}




}
