<?php

namespace App\Validator\Constraints;


use App\Entity\Teilnehmer;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TurnierFormValidator extends ConstraintValidator
{
    public function validate($teilnehmer, Constraint $constraint)
    {

        /* @var $form \App\Entity\Teilnehmer */
        /* @var $constraint TurnierForm */



        if ($teilnehmer->getAgegroupe()->getMaxAge() < $this->calcAge($teilnehmer)) {

            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    private function calcAge(Teilnehmer $teilnehmer)
    {
        $dateTimeBirthDate = $teilnehmer->getBirthDate();
        $diff = $dateTimeBirthDate->diff((new \DateTime()));
        return $diff->y;
    }
}
