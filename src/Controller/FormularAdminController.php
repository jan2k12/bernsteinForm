<?php

namespace App\Controller;

use App\Entity\Teilnehmer;
use App\Entity\TurnierForm;
use App\Form\TeilnehmerForm;
use App\Services\TeilnehmerFileService;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Stream;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FormularAdminController extends Controller {
	/**
	 * @Route("/admin", name="formular_admin")
	 */
	public function index( AuthorizationCheckerInterface $authChecker ) {
		if ( false === $authChecker->isGranted( 'ROLE_ADMIN' ) ) {
			throw new AccessDeniedException( 'Unable to access this page!' );
		}

		$turniere = $this->getDoctrine()->getRepository( TurnierForm::class )->findAll();

		return $this->render( 'admin/index.html.twig',
			[ 'turniere'     => $turniere,
			  'free_places'  => $this->countFreePlaces( $turniere ),
			  'participiens' => $this->getParticipiensForTurnierHash( $turniere ),
			] );
	}

	/**
	 * @Route("/deactivate", name="deactivate_turnier")
	 * @param int $turnierId
	 */
	public function deactivateTurnier(Request $request){
		if( $request->isXmlHttpRequest()){
			return new JsonResponse($request->request->get('id'));
		}
		return new JsonResponse('failed');
	}

	/**
	 * @Route("/showturnier/{turnierId}", name="admin_show_turnier")
	 * @param Request $request
	 */
	public function showTurnier(Request $request,$turnierId, AuthorizationCheckerInterface $authChecker ){

		if ( false === $authChecker->isGranted( 'ROLE_ADMIN' ) ) {
			throw new AccessDeniedException( 'Unable to access this page!' );
		}

		$teilnehmer=$this->getDoctrine()->getRepository(Teilnehmer::class)->findByTurnierId($turnierId);


		return $this->render('admin/teilnehmer.html.twig',['teilnehmers'=>$teilnehmer,'id'=>$turnierId]);
	}

	/**
	 * @Route("/getTotalList/{turnierId}",name="getTotalList")
	 * @param int $turnierId
	 */
	public function getTotalList($turnierId, TeilnehmerFileService $service){
		$fileName="AlleTeilnehmer.csv";
		$file=$service->createTotalListCsv($turnierId);
		$response=new Response($file);
		$disposition=$response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,$fileName);
		$response->headers->set('Content-Disposition',$disposition);
		return $response;
	}

	/**
	 * @Route("/getPaidlist/{turnierId}",name="getPaidlist")
	 * @param int $turnierId
	 */
	public function getPaidlist($turnierId, TeilnehmerFileService $service){
		$fileName="AlleBezahltenTeilnehmer.csv";
		$file=$service->createPaidListCsv($turnierId);
		$response=new Response($file);
		$disposition=$response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,$fileName);
		$response->headers->set('Content-Disposition',$disposition);
		return $response;
	}

	/**
	 *
	 * @Route("/setPaid/{teilnehmerId}",name="setPaid")
	 * @param $teilnehmerId
	 *
	 * @return Response
	 */
	public function setPaid($teilnehmerId){
		$teilnehmer=$this->getDoctrine()
		                 ->getRepository(Teilnehmer::class)
		                 ->findOneBy( ['id'=>$teilnehmerId]);
		$teilnehmer->setHasPaid(true);
		$this->getDoctrine()->getManager()->persist($teilnehmer);
		$this->getDoctrine()->getManager()->flush();

		return new Response('saved');
	}

	/**
	 * @Route("/getPaidArtemisFile/{turnierId}",name="getPaidArtemisFile")
	 * @param int $turnierId
	 */
	public function getPaidArtemisFile($turnierId, TeilnehmerFileService $service){

		$fileName="Anmeldung.txt";
		$file=$service->createArtemisFile($turnierId);
		$response=new Response($file);
		$disposition=$response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,$fileName);
		$response->headers->set('Content-Disposition',$disposition);
		return $response;

	}

	private function countFreePlaces( array $turniere ) {
		$returnHash = [];
		foreach ( $turniere as $turnier ) {
			/**@var TurnierForm $turnier */
			$count                           = $this->getDoctrine()->getRepository( Teilnehmer::class )
			                                        ->createQueryBuilder( 't' )
			                                        ->select( 'count(t.id)' )
			                                        ->where( 't.turnier=:turnier_id' )
			                                        ->setParameter( 'turnier_id', $turnier->getId() )
			                                        ->getQuery()->getSingleScalarResult();
			$returnHash[ $turnier->getId() ] = ( $turnier->getFreePlaces() - $count ) < 0 ? 0 : ( $turnier->getFreePlaces() - $count );

		}

		return $returnHash;
	}

	private function getParticipiens( $turnier ) {
		$count = $this->getDoctrine()->getRepository( Teilnehmer::class )
		              ->createQueryBuilder( 't' )
		              ->select( 'count(t.id)' )
		              ->where( 't.turnier=:turnier_id' )
		              ->setParameter( 'turnier_id', $turnier->getId() )
		              ->getQuery()->getSingleScalarResult();

		return $count;
	}

	private function getParticipiensForTurnierHash( $turniere ) {
		$returnHash = array();
		foreach ( $turniere as $turnier ) {
			$returnHash[ $turnier->getId() ] = $this->getParticipiens( $turnier );
		}

		return $returnHash;
	}
}
