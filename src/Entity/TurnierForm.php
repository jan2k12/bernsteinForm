<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TurnierFormRepository")
 *
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


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
     * @var integer
     */
    private $freePlaces;

    /**
     * @ORM\Column(type="boolean", options={"default":"1"})
     * @var boolean
     */
    private $bankPayment = true;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     * @var bool
     */
    private $isActive = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Teilnehmer",mappedBy="turnier")
     * @ORM\JoinColumn(nullable=false)
     * @var Teilnehmer[]
     */
    private $teilnehmer;

    /**
     * @return Teilnehmer[]
     */
    public function getTeilnehmer(): array
    {
        return $this->teilnehmer;
    }

    /**
     * @param Teilnehmer[] $teilnehmer
     */
    public function setTeilnehmer(array $teilnehmer): void
    {
        $this->teilnehmer = $teilnehmer;
    }


    /**
     * @return \integer
     */
    public function getFreePlaces(): int
    {
        return $this->freePlaces;
    }

    /**
     * @param \DateTime $freePlaces
     */
    public function setFreePlaces(int $freePlaces): void
    {
        $this->freePlaces = $freePlaces;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->end_date;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->end_date = $endDate;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->start_date;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate): void
    {
        $this->start_date = $startDate;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isBankPayment(): bool
    {
        return $this->bankPayment;
    }

    /**
     * @param bool $bankPayment
     */
    public function setBankPayment(bool $bankPayment): void
    {
        $this->bankPayment = $bankPayment;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }


}
