<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 21.03.18
 * Time: 21:11
 */

namespace App\Services;


use App\Entity\Teilnehmer;


class MailerService {

	public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer) {
		$this->twig=$twig;
		$this->mailer=$mailer;
	}

	public function sendTeilnehmerPaidMail(Teilnehmer $teilnehmer ) {
		$message=new \Swift_Message('Turnier aktivierung');

		$message->setFrom('noreply@bernsteineagles-michelbach.de');
		$message->setTo($teilnehmer->getEmail());

		$message=$message->setBody($this->twig->render('mails/haspaid.html.twig',['teilnehmer'=>$teilnehmer]),'text/html');
		$this->mailer->send($message);
	}

	public function sendTeilnehmerRegisterMails(Teilnehmer $teilnehmer ) {

		$turnier=$teilnehmer->getTurnier();
		$message=new \Swift_Message('Neue Anmeldung für '.$turnier->getName());
		$message->setFrom('noreply@bernsteineagles-michelbach.de');
		$message->setTo($teilnehmer->getEmail());
		$message->setCharset('ISO-8859-1');
		$message->setBody($this->twig->render(
			'mails/newRegisterToParticipant.html.twig',['teilnehmer'=>$teilnehmer,'turnier'=>$turnier],'text/html'
		));
		$this->mailer->send($message);
	}
}