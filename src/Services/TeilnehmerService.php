<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 31.03.18
 * Time: 12:35
 */

namespace App\Services;


use App\Entity\Teilnehmer;
use App\Entity\TurnierForm;
use Doctrine\ORM\EntityManagerInterface;

class TeilnehmerService
{

    private $em;


    /**
     * FormularService constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param TurnierForm $turnier
     *
     * @return int
     */
    public function calcFreePlaces(TurnierForm $turnier)
    {

        $count = $this->getPaidTeilnehmer($turnier);
        $turnierCount = $turnier->getFreePlaces() - $count;
        $returnCount = $turnierCount < 0 ? 0 : $turnierCount;


        return $returnCount;
    }

    public function getPaidTeilnehmer(TurnierForm $turnier)
    {
        if (!$turnier->isBankPayment()) {
            return $this->em->getRepository(Teilnehmer::class)
                ->createQueryBuilder('t')
                ->select('count(t.id)')
                ->where('t.turnier=:turnier_id')
                ->setParameter('turnier_id', $turnier->getId())
                ->getQuery()
                ->getSingleScalarResult();
        }

        $count = $this->em->getRepository(Teilnehmer::class)
            ->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.turnier=:turnier_id')
            ->andWhere('t.hasPaid=1')
            ->setParameter('turnier_id', $turnier->getId())
            ->getQuery()->getSingleScalarResult();
        return $count;
    }

    public function getParticipiens(TurnierForm $turnier)
    {
        return $this->em->getRepository(Teilnehmer::class)
            ->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.turnier=:turnier_id')
            ->setParameter('turnier_id', $turnier->getId())
            ->getQuery()->getSingleScalarResult();
    }
}