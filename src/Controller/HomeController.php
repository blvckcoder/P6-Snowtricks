<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, TrickRepository $tricksRepository): Response
    {
        $pageSize = TrickRepository::PAGINATOR_PER_PAGE;
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $tricksRepository->getTrickPaginator($offset);

        $totalTricks = count($paginator);
        $totalPages = ceil($totalTricks / $pageSize);

        $previous = max($offset - $pageSize, 0);
        $next = min($offset + $pageSize, $totalTricks - $pageSize);

        return $this->render('home/index.html.twig', [
            'tricks' => $paginator,
            'previous' => $previous,
            'next' => $next,
            'totalPages' => $totalPages,
            'currentPage' => floor($offset / $pageSize) + 1,
            'pageSize' => $pageSize,
            'totalTricks' => $totalTricks
        ]);
    }
}