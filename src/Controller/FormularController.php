<?php

namespace App\Controller;

use App\Entity\Teilnehmer;
use App\Entity\TurnierForm;
use App\Form\TeilnehmerForm;
use App\Services\FormularService;
use App\Services\MailerService;
use App\Services\TeilnehmerService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class FormularController extends AbstractController
{
    /**
     * @Route("/", name="formular-Index")
     */
    public function index(Request $request, FormularService $formular_service, TeilnehmerService $teilnehmer_service)
    {
        $teilnehmer = new Teilnehmer();
        $form = $this->createForm(TeilnehmerForm::class, $teilnehmer);

        $form->handleRequest($request);
        $turnier = $formular_service->getActiveFormsForDateRange(new \DateTime());
        if(!$turnier){
            return $this->render('formIndex.html.twig',
                ['form' =>null]);
        }
        $counter = $teilnehmer_service->calcFreePlaces($turnier[0]);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teilnehmer);
            $em->flush();
            $url = $this->generateUrl('success', ['teilnehmerId' => $teilnehmer->getId()]);
            return $this->redirect($url);
        }


        return $this->render('formIndex.html.twig',
            ['form' => $form->createView(), 'counter' => $counter]);

    }

    /**
     * @Route("/form/success/{teilnehmerId}", name="success")
     */
    public function success($teilnehmerId, MailerService $mailer_service)
    {
        $mailer_service->sendTeilnehmerRegisterMails($this->getDoctrine()->getRepository(Teilnehmer::class)->find($teilnehmerId));
        return $this->render('formsuccess.html.twig');
    }

    /**
     * @Route("/list/{turnierId}", name="public_turnier_list")
     * @param Request $request
     * @param $turnierId
     */
    public function getList(Request $request, $turnierId, TeilnehmerService $teilnehmer_service)
    {
        /** @var TurnierForm $turnier */
        $turnier = $this->getDoctrine()->getRepository(TurnierForm::class)->find($turnierId);
        if (!$turnier->isBankPayment()) {
            $teilnehmer = $this->getDoctrine()->getRepository(Teilnehmer::class)->findByTurnierId($turnierId);
        } else {
            $teilnehmer = $this->getDoctrine()->getRepository(Teilnehmer::class)->findByPaidTurnierId($turnierId);
        }
        return $this->render('public_list.html.twig', ['teilnehmers' => $teilnehmer, 'turnier' => $turnier, 'free_places' => $teilnehmer_service->calcFreePlaces($turnier)]);

    }
}
