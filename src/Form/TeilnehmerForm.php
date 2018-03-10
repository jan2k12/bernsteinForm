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
use App\Entity\TurnierForm;
use App\Repository\TurnierFormRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\Validator\Constraints\Length;

class TeilnehmerForm extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->setCompound(true)
			->add('name', TextType::class)
			->add('prename', TextType::class)
			->add('street', TextType::class)
			->add('plz', IntegerType::class,[
				'error_bubbling'=>true
			])
			->add('city',TextType::class)
			->add('country',CountryType::class,[
				'preferred_choices'=>array('DE')
			])
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
			])
			->add('society', TextType::class)
			->add('turnier',EntityType::class,[
				'class'=>TurnierForm::class,
				'query_builder'=>function(EntityRepository $tf){
					return $tf->createQueryBuilder( 'tf' )
					            ->where( 'tf.start_date <= :date' )
					            ->andWhere( 'tf.end_date >= :date' )
					            ->setParameter( 'date', new \DateTime() );
				},
				'choice_label'=>'name'
			])
			->add('submit',SubmitType::class);
	}

}