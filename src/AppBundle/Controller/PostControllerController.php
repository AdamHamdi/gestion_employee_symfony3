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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;

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
    public function newPost(Request $request): Response 
    {

        $post= new Post();
        $form = $this->createForm(PostType::class, $post);
        // ->add('title', TextType::class)
        // ->add('description', TextareaType::class)
        // ->getForm();

    $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            
            if ($form->isSubmitted() && $form->isValid()) {
                
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($post);
                $entityManager->flush();
                return $this->redirectToRoute('liste.posts') ;
            }
        }
        return $this->render('posts/add.html.twig',[
            'form'=>$form->createView(),
            ]) ;
    }
    /**
     * @Route("posts", name="liste.posts")
     */
    public function posts(){
        $posts=$this->getDoctrine()->getRepository("AppBundle\Entity\Post")->findAll();
        return $this->render('posts/posts.html.twig',['posts'=>$posts]);
    }

     /**
     * @Route("post/{id}/edit", name="post.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('liste.posts');
        }

        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }
     /**
     * @Route("post/{id}", name="post.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('liste.posts');
    }

}
