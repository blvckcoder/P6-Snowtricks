<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick', name: 'tricks_')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('tricks/index.html.twig');
    }

    #[Route('/{slug}', name: 'show')]
    public function show(Trick $trick): Response
    {
        return $this->render('tricks/show.html.twig', compact('trick'));
    }
}