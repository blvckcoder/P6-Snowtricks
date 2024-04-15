<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Entity\Comment;
use App\Form\CommentFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/trick', name: 'tricks_')]
class BlogController extends AbstractController
{

    #[Route('/{slug}', name: 'show')]
    public function show(Request $request, Trick $trick, CommentFormType $commentForm): Response
    {
        $images = $trick->getMedia()->filter(function($media) {
            return $media instanceof Image;
        });
    
        $videos = $trick->getMedia()->filter(function($media) {
            return $media instanceof Video;
        });

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick,
            'images' => $images,
            'videos' => $videos, 
            'commentForm' => $form->createView(),
        ]);
    }
}