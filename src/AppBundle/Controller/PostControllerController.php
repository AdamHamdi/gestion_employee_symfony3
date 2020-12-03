<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use AppBundle\Repository\PostRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostControllerController extends Controller 
{

    //     private $repository;
    //     private $em;

    //     public function __construct(PostRepository $repository ,EntityManagerInterface $em){
        
        
    //     $this->repository=$repository;
    //     $this->em=$em;
    // }
     /**
     * @Route("/post/add", name="post.new")
     */
    public function newPost(Request $request){

        $post= new Post();
        $form=$this->createForm(PostType::class ,$post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('liste.posts') ;
        }
        return $this->render('posts/add.html.twig',['form'=>$form->createView()]) ;
    }
    /**
     * @Route("posts", name="liste.posts")
     */
    public function posts(){
        $posts=$this->getDoctrine()->getRepository("AppBundle\Entity\Post")->findAll();
        return $this->render('posts/posts.html.twig',['posts'=>$posts]);
    }
}
