<?php

namespace App\Controller;

use App\Entity\Teilnehmer;
use App\Entity\TurnierForm;
use App\Form\TeilnehmerForm;
use App\Services\FormularService;
use App\Services\MailerService;
use App\Services\TeilnehmerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;

class FormularController extends Controller {
	/**
	 * @Route("/", name="formular-Index")
	 */
	public function index( Request $request, FormularService $formular_service, TeilnehmerService $teilnehmer_service ) {
		$teilnehmer = new Teilnehmer();
		$form       = $this->createForm( TeilnehmerForm::class, $teilnehmer );

		$form->handleRequest( $request );
		$turnier = $formular_service->getFormsForDateRange( new \DateTime() );
		$counter = $teilnehmer_service->calcFreePlaces($turnier[0]);
		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $teilnehmer );
			$em->flush();
			$url=$this->generateUrl('success',['teilnehmerId'=>$teilnehmer->getId()]);
			return $this->redirect( $url );
		}


		return $this->render( 'formIndex.html.twig',
			[ 'form' => $form->createView(), 'counter' => $counter ] );

	}

	/**
	 * @Route("/form/success/{teilnehmerId}", name="success")
	 */
	public function success($teilnehmerId,MailerService $mailer_service) {
		$mailer_service->sendTeilnehmerRegisterMails($this->getDoctrine()->getRepository(Teilnehmer::class)->find($teilnehmerId));
		return $this->render('formsuccess.html.twig');
	}

	/**
	 * @Route("/list/{turnierId}", name="public_turnier_list")
	 * @param Request $request
	 * @param $turnierId
	 */
	public function getList(Request $request,$turnierId,TeilnehmerService $teilnehmer_service){
		$teilnehmer=$this->getDoctrine()->getRepository(Teilnehmer::class)->findByTurnierId($turnierId);
		$turnier=$this->getDoctrine()->getRepository(TurnierForm::class)->find($turnierId);
		return $this->render('public_list.html.twig',['teilnehmers'=>$teilnehmer,'turnier'=>$turnier,'free_places'=>$teilnehmer_service->calcFreePlaces($turnier)]);

	}
}
