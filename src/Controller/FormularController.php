<?php

namespace App\Controller;

use App\Entity\Teilnehmer;
use App\Entity\TurnierForm;
use App\Form\TeilnehmerForm;
use App\Services\FormularService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;

class FormularController extends Controller {
	/**
	 * @Route("/", name="formular-Index")
	 */
	public function index( Request $request, FormularService $formular_service ) {
		$teilnehmer = new Teilnehmer();
		$form       = $this->createForm( TeilnehmerForm::class, $teilnehmer );

		$form->handleRequest( $request );
		$turnier = $formular_service->getFormsForDateRange( new \DateTime() );
		$turnier = $turnier[0];
		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $teilnehmer );

			$turnier->setFreePlaces( ( $turnier->getFreePlaces() - 1 ) );
			$em->persist( $turnier );
			$em->flush();
			$url=$this->generateUrl('success');
			return $this->redirect( $url );
		}

		return $this->render( 'formIndex.html.twig',
			[ 'form' => $form->createView(), 'counter' => $turnier->getFreePlaces() ] );

	}

	/**
	 * @Route("/form/success", name="success")
	 */
	public function success() {
		return $this->render('formsuccess.html.twig');
	}
}
