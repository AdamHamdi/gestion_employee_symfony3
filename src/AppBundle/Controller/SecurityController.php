<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

class SecurityController extends Controller
{
     /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authentication)
    {
        // get the login error if there is one
    $error = $authentication->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authentication->getLastUsername();
    
    return $this->render('security/login.html.twig',[
        'last_username'=>$lastUsername,
        'error'=>$error,
    ]);
    }
    /**
  * @Route("/logout", name="logout")
  */
 public function logout(){

}
}
