<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TurnierForm extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Chosen AgeGroup does not fit to age';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
