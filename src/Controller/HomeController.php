<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TrickRepository $tricksRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'tricks' => $tricksRepository->findAll()
        ]);
    }
}