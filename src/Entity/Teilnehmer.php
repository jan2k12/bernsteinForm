<?php

namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TeilnehmerRepository")
 *@\App\Validator\Constraints\TurnierForm()
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
     * @ORM\Column(type="boolean" )
     * @var boolean
     */
    private $hasPaid = 0;

    /**
     * @ORM\Column(type="string" )
     * @var string
     */
    private $gender = "Männlich";

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @var \DateTime
     */
    private $birthDate;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $agb_accepted = "false";

    /**
     * @ORM\Column(type="datetime" )
     * @var \DateTime
     */
    private $created_at;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * Teilnehmer constructor.
     *
     * @param \DateTime $created_at
     */
    public function __construct()
    {
        $this->created_at = new \DateTime('now');
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getName(): ?string
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
     * @return string
     */
    public function getPrename(): ?string
    {
        return $this->prename;
    }

    /**
     * @param string $prename
     */
    public function setPrename(string $prename): void
    {
        $this->prename = $prename;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return Agegroup
     */
    public function getAgegroupe(): ?Agegroup
    {
        return $this->agegroupe;
    }

    /**
     * @param Agegroup $agegroupe
     */
    public function setAgegroupe(Agegroup $agegroupe): void
    {
        $this->agegroupe = $agegroupe;
    }

    /**
     * @return Bowclass
     */
    public function getBowclass(): ?Bowclass
    {
        return $this->bowclass;
    }

    /**
     * @param Bowclass $bowclass
     */
    public function setBowclass(Bowclass $bowclass): void
    {
        $this->bowclass = $bowclass;
    }

    /**
     * @return string
     */
    public function getSociety(): ?string
    {
        return $this->society;
    }

    /**
     * @param string $society
     */
    public function setSociety(string $society): void
    {
        $this->society = $society;
    }

    /**
     * @return TurnierForm
     */
    public function getTurnier(): ?TurnierForm
    {
        return $this->turnier;
    }

    /**
     * @param TurnierForm $turnier
     */
    public function setTurnier(TurnierForm $turnier): void
    {
        $this->turnier = $turnier;
    }

    /**
     * @return bool
     */
    public function isHasPaid(): bool
    {
        return $this->hasPaid;
    }

    /**
     * @param bool $hasPaid
     */
    public function setHasPaid(bool $hasPaid): void
    {
        $this->hasPaid = $hasPaid;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }


    public function getKennung()
    {
        return "T-" . str_pad($this->id, 3, 0, STR_PAD_LEFT);
    }

    /**
     * @return bool
     */
    public function isAgbAccepted(): bool
    {
        return $this->agb_accepted;
    }

    /**
     * @param bool $agb_accepted
     */
    public function setAgbAccepted(bool $agb_accepted): void
    {
        $this->agb_accepted = $agb_accepted;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate(\DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }




}
