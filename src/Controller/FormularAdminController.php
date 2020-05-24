<?php

namespace App\Controller;

use App\Entity\Teilnehmer;
use App\Entity\TurnierForm;
use App\Services\MailerService;
use App\Services\TeilnehmerFileService;
use App\Services\TeilnehmerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FormularAdminController extends AbstractController {
	/**
	 * @Route("/admin", name="formular_admin")
	 */
	public function index( AuthorizationCheckerInterface $authChecker, TeilnehmerService $teilnehmer_service ) {
		if ( false === $authChecker->isGranted( 'ROLE_ADMIN' ) ) {
			throw new AccessDeniedException( 'Unable to access this page!' );
		}

		$turniere = $this->getDoctrine()->getRepository( TurnierForm::class )->findAll();

		return $this->render( 'admin/index.html.twig',
			[
				'turniere'         => $turniere,
				'free_places'      => $this->countFreePlaces( $turniere, $teilnehmer_service ),
				'paidParticipiens' => $this->getParticipiensForTurnierHash( $turniere, $teilnehmer_service ),
				'participiens'     => $this->getParticipiens( $turniere,$teilnehmer_service ),
			] );
	}

	/**
	 * @Route("/deactivate", name="deactivate_turnier")
	 * @param int $turnierId
	 */
	public function deactivateTurnier( Request $request ) {
		if ( $request->isXmlHttpRequest() ) {
			return new JsonResponse( $request->request->get( 'id' ) );
		}

		return new JsonResponse( 'failed' );
	}

	/**
	 * @Route("/showturnier/{turnierId}", name="admin_show_turnier")
	 * @param Request $request
	 */
	public function showTurnier(
		Request $request,
		$turnierId,
		AuthorizationCheckerInterface $authChecker,
		TeilnehmerService $teilnehmer_service
	) {

		if ( false === $authChecker->isGranted( 'ROLE_ADMIN' ) ) {
			throw new AccessDeniedException( 'Unable to access this page!' );
		}

		$teilnehmer = $this->getDoctrine()->getRepository( Teilnehmer::class )->findByTurnierId( $turnierId );

		$turnier = $this->getDoctrine()->getRepository( TurnierForm::class )->find( $turnierId );

		$countFreePlaces = $teilnehmer_service->calcFreePlaces( $turnier );

		$paidPlaces = $turnier->getFreePlaces() - $countFreePlaces;

		return $this->render( 'admin/teilnehmer.html.twig',
			[
				'teilnehmers' => $teilnehmer,
				'turnier'     => $turnier,
				'paidPlaces'  => $paidPlaces,
				'freePlaces'  => $countFreePlaces,
			] );
	}

	/**
	 * @Route("/getTotalList/{turnierId}",name="getTotalList")
	 * @param int $turnierId
	 */
	public function getTotalList( $turnierId, TeilnehmerFileService $service ) {
		$fileName    = "AlleTeilnehmer.csv";
		$file        = $service->createTotalListCsv( $turnierId,$fileName );
		$response    = new Response( $file );
		$disposition = $response->headers->makeDisposition( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName );
		$response->headers->set( 'Content-Disposition', $disposition );
		$response->headers->set( 'Content-Type','text/csv' );
		$response->headers->set( 'Pragma','public' );
		$response->headers->set( 'Expires','0' );
		$response->headers->set( 'Cache-Control','must-revalidate, post-check=0, pre-check=0' );
		$response->headers->set( 'Content-Description','File Transfer' );

		return $response;
	}

	/**
	 * @Route("/getPaidlist/{turnierId}",name="getPaidlist")
	 * @param int $turnierId
	 */
	public function getPaidlist( $turnierId, TeilnehmerFileService $service ) {
		$fileName    = "AlleBezahltenTeilnehmer.csv";
		$file        = $service->createPaidListCsv( $turnierId,$fileName );
		$response    = new Response( $file );
		$disposition = $response->headers->makeDisposition( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName );
		$response->headers->set( 'Content-Disposition', $disposition );
		$response->headers->set( 'Content-Type','text/csv' );
		$response->headers->set( 'Pragma','public' );
		$response->headers->set( 'Expires','0' );
		$response->headers->set( 'Cache-Control','must-revalidate, post-check=0, pre-check=0' );
		$response->headers->set( 'Content-Description','File Transfer' );

		return $response;
	}

	/**
	 *
	 * @Route("/setPaid/{teilnehmerId}",name="setPaid")
	 * @param $teilnehmerId
	 *
	 * @return Response
	 */
	public function setPaid( $teilnehmerId, MailerService $mailer ) {
		$teilnehmer = $this->getDoctrine()
		                   ->getRepository( Teilnehmer::class )
		                   ->findOneBy( [ 'id' => $teilnehmerId ] );
		$teilnehmer->setHasPaid( ! $teilnehmer->isHasPaid() );
		$this->getDoctrine()->getManager()->persist( $teilnehmer );
		$this->getDoctrine()->getManager()->flush();

		return new Response( 'saved' );
	}

	/**
	 * @Route("/getPaidArtemisFile/{turnierId}",name="getPaidArtemisFile")
	 * @param int $turnierId
	 */
	public function getPaidArtemisFile( $turnierId, TeilnehmerFileService $service ) {

		$fileName    = "Anmeldung.txt";
		$file        = $service->createArtemisFile( $turnierId ,$fileName);
		$response    = new Response( $file );
		$disposition = $response->headers->makeDisposition( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName );
		$response->headers->set( 'Content-Disposition', $disposition );
		$response->headers->set( 'Content-Type','text/csv' );
		$response->headers->set( 'Pragma','public' );
		$response->headers->set( 'Expires','0' );
		$response->headers->set( 'Cache-Control','must-revalidate, post-check=0, pre-check=0' );
		$response->headers->set( 'Content-Description','File Transfer' );
		return $response;

	}

	private function countFreePlaces( array $turniere, TeilnehmerService $teilnehmer_service ) {
		$returnHash = [];
		foreach ( $turniere as $turnier ) {
			$returnHash[ $turnier->getId() ] = $teilnehmer_service->calcFreePlaces( $turnier );
		}

		return $returnHash;
	}

	private function getParticipiens( $turniere, TeilnehmerService $teilnehmer_service ) {
		$returnHash = array();
		foreach ( $turniere as $turnier ) {
			$returnHash[$turnier->getId()] = $teilnehmer_service->getParticipiens($turnier);

		}
		return $returnHash;
	}

	private function getParticipiensForTurnierHash( $turniere, TeilnehmerService $teilnehmer_service ) {
		$returnHash = array();
		foreach ( $turniere as $turnier ) {
			$returnHash[ $turnier->getId() ] = $teilnehmer_service->getPaidTeilnehmer( $turnier );
		}

		return $returnHash;
	}
}
