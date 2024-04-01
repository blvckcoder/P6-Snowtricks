<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\CommentFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/trick', name: 'tricks_')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('tricks/index.html.twig');
    }

    #[Route('/{slug}', name: 'show')]
    public function show(Request $request, Trick $trick, CommentFormType $commentForm): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick, 
            'commentForm' => $form->createView(),
        ]);
    }
}