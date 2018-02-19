<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 19.02.18
 * Time: 23:41
 */

namespace App\Form;


use App\Entity\Agegroup;
use App\Entity\Bowclass;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;

class TeilnehmerForm extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add('email',EmailType::class)
			->add('bowclass', EntityType::class,[
				'class'=>Bowclass::class,
				'choice_label'=>'name',
				'multiple'=>false,
				'expanded'=>false
			])
			->add('agegroupe', EntityType::class,[
				'class'=>Agegroup::class,
				'choice_label'=>'name',
				'multiple'=>false,
				'expanded'=>false
			])->add('country',CountryType::class)
			->add('submit',SubmitType::class);
	}

}