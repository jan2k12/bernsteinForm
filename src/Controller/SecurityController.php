<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authutils)
    {
		$error=$authutils->getLastAuthenticationError();
		$lastUsername=$authutils->getLastUsername();
		return $this->render('security/login.html.twig',['last_username'=>$lastUsername,'error'=>$error]);
    }


}
