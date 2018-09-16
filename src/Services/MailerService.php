<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 21.03.18
 * Time: 21:11
 */

namespace App\Services;


use App\Entity\Teilnehmer;
use Monolog\Logger;


class MailerService {

	public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer) {
		$this->twig=$twig;
		$this->mailer=$mailer;
	}

	public function sendTeilnehmerRegisterMails(Teilnehmer $teilnehmer ) {
		try{
		$turnier=$teilnehmer->getTurnier();
		$message=new \Swift_Message('Neue Anmeldung für '.$turnier->getName());
		$message->setFrom(getenv('FROM_EMAIL_ADDRESS'));
		$message->setTo($teilnehmer->getEmail());
		$message->setBcc('info@bernsteineagles.de');
		$message->setCharset('UTF-8');
		$message->setBody($this->twig->render(
			'mails/newRegisterToParticipant.html.twig',['teilnehmer'=>$teilnehmer,'turnier'=>$turnier]
		),'text/html','UTF-8');
		$this->mailer->send($message);
		}catch(\Exception $ex){
			error_log($ex->getMessage());
		}
	}
}