<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PostControllerController extends Controller
{
     /**
     * @Route("/post/add", name="post.new")
     */
    public function newPost(Request $request){

        $post= new Post();
        $form=$this->createForm(PostType::class,$post);
        $form->add('title')->add('description');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager=$this->getDoctrine()->getManager();
            $this-> entityManager->persist($post);
            $this-> entityManager->flush();
        }
        return $this->render('blog/add.html.twig',['form'=>$form->createView()]) ;
    }
}
