<?php

namespace App\Controller;

use App\Entity\Teilnehmer;
use App\Form\TeilnehmerForm;
use App\Services\FormularService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;

class FormularController extends Controller {
	/**
	 * @Route("/", name="formular-Index")
	 */
	public function index( FormularService $formular_service) {

		$dateTime=new \DateTime();
		$data=$formular_service->getFormsForDateRange($dateTime);
		$teilnehmer=new Teilnehmer();
		$form=$this->createForm(TeilnehmerForm::class,$teilnehmer);


		return $this->render('formIndex.html.twig',['form'=>$form->createView()]);

	}
}
