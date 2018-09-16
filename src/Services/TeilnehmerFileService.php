<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 10.03.18
 * Time: 14:12
 */

namespace App\Services;


use App\Entity\Teilnehmer;
use Doctrine\ORM\EntityManagerInterface;

class TeilnehmerFileService {

	private $em;


	/**
	 * FormularService constructor.
	 */
	public function __construct( EntityManagerInterface $em ) {
		$this->em = $em;
	}

	public function createTotalListCsv( $turnierId ,$filename) {
		$teilnehmer = $this->em->getRepository( Teilnehmer::class )->findByTurnierId( $turnierId );

		$headers = [
			'teilnehmerkennung',
			'geschlecht',
			'name',
			'vorname',
			'email',
			'verein',
			'altersgruppe',
			'bogenklasse',
			'bezahlt',
		];
		$file    = fopen( sys_get_temp_dir().'/'.$filename, 'w' );
		fputcsv( $file, $headers );
		foreach ( $teilnehmer as $user ) {
			/** @var Teilnehmer $user */
			$contentHash = [
				$this->convertToMs('T-'.str_pad($user->getId(),3,0,STR_PAD_LEFT)),
				$this->convertToMs($user->getGender()??' '),
				$this->convertToMs($user->getName()),
				$this->convertToMs($user->getPrename()),
				$this->convertToMs($user->getEmail()),
				$this->convertToMs($user->getSociety()),
				$user->getAgegroupe()->getName(),
				$user->getBowclass()->getName(),
				$user->isHasPaid()?'ja':'nein'
			];
			fputcsv($file,$contentHash);
		}
		fclose($file);
		return file_get_contents(sys_get_temp_dir().'/'.$filename);

	}

	public function createPaidListCsv( $turnierId,$filename ) {
		$teilnehmer = $this->em->getRepository( Teilnehmer::class )->findByPaidTurnierId( $turnierId );

		$headers = [
			'teilnehmerkennung',
			'geschlecht',
			'name',
			'vorname',
			'email',
			'verein',
			'altersgruppe',
			'bogenklasse',
			'bezahlt',
		];
		$file    = fopen( sys_get_temp_dir().'/'.$filename, 'w' );
		fputcsv( $file, $headers );
		foreach ( $teilnehmer as $user ) {
			/** @var Teilnehmer $user */
			$contentHash = [
				$this->convertToMs('T-'.str_pad($user->getId(),3,0,STR_PAD_LEFT)),
				$this->convertToMs($user->getGender()??' '),
				$this->convertToMs($user->getName()),
				$this->convertToMs($user->getPrename()),
				$this->convertToMs($user->getEmail()),
				$this->convertToMs($user->getSociety()),
				$user->getAgegroupe()->getName(),
				$user->getBowclass()->getName(),
				$user->isHasPaid()?'ja':'nein'
			];
			fputcsv($file,$contentHash);
		}
		fclose($file)  ;
		return file_get_contents(sys_get_temp_dir().'/'.$filename);
	}

	public function createArtemisFile($turnierId,$filename){
		$teilnehmers = $this->em->getRepository( Teilnehmer::class )->findByPaidTurnierId( $turnierId );

		$file=fopen(sys_get_temp_dir().'/'.$filename,'w');

		foreach($teilnehmers as $teilnehmer){
			fwrite($file,$this->buildAnmeldungsstring($teilnehmer));
		}
		fclose($file);
		return file_get_contents(sys_get_temp_dir().'/'.$filename);



	}

	private function buildAnmeldungsstring(Teilnehmer $teilnehmer ) {
		if($teilnehmer->getGender()=="Männlich"|| $teilnehmer->getGender()=="Herr"){
			$gender='1 M&auml;nnlich';
		}elseif($teilnehmer->getGender()=="Weiblich" || $teilnehmer->getGender()=="Frau"){
			$gender='2 Weiblich';
		}else{
			$gender='';
		}
		$Nachricht = "--- Anmeldung --- --- ---". $teilnehmer->getCreatedAt()->format('d.m.Y H:i:s') ."---\n";
		$Nachricht .= "  Geschlecht:    ".$gender."\n";
		$Nachricht .= "  Nachname:      ".$teilnehmer->getName()."\n";
		$Nachricht .= "  Vorname:       ".$teilnehmer->getPrename()."\n";
		$Nachricht .= "  E-Mail:        ".$teilnehmer->getEmail()."\n";
		$Nachricht .= "  Verein:        ".$teilnehmer->getSociety()."\n";
		$Nachricht .= "  Bogen:         ".htmlentities($teilnehmer->getBowclass()->getName()."\n");
		$Nachricht .= "  Altersgruppe   ".htmlentities($teilnehmer->getAgegroupe()->getName()."\n");
		return $Nachricht;
	}

	private function convertToMs( $string ) {
		$charset=mb_detect_encoding($string,"UTF-8, ISO-8859-1, ISO-8859-15",true);
		return mb_convert_encoding($string,'Windows-1252',$charset);
	}
}