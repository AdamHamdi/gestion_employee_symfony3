<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\FormFactoryInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
 * @Route("/register", name="register")
 */
public function register(UserPasswordEncoderInterface $passwordEncoder ,Request $request)
{
    $user =new User();
    $form=$this->createForm(UserType::class,$user);
    $form->handleRequest($request);


    if($form->isSubmitted()&& $form->isValid()){
        
        $password =$passwordEncoder->encodePassword(
            $user,$user->getPlainPassword()
        );
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success','compte créé avec succés !');
       
        return $this->redirectToRoute('liste.posts');
    }

    return $this->render('users/register.html.twig', ['form'=>$form->createView()]);
}
}
