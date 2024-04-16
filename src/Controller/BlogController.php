<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Image;
use App\Entity\Video;
use App\Entity\Comment;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/trick', name: 'tricks_')]
class BlogController extends AbstractController
{

    #[Route('/{slug}', name: 'show')]
    public function show(Request $request, Trick $trick, EntityManagerInterface $entityManager, CommentFormType $commentForm): Response
    {
        $imageRepository = $entityManager->getRepository(Image::class);
        $images = $imageRepository->findBy(['trick' => $trick]);

        $videoRepository = $entityManager->getRepository(Video::class);
        $videos = $videoRepository->findBy(['trick' => $trick]);

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