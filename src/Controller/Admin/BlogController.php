<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Video;
use App\Entity\Trick;
use App\Form\TrickFormType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/trick', name:'admin_trick_')]
class BlogController extends AbstractController
{
    #[Route('/new', name:'new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, PictureService $pictureService): Response
    {
        $trick = new Trick();
        $trick->setAuthor($this->getUser());

        $form = $this->createForm(TrickFormType::class, $trick);

        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()) {
            // IMAGES
            $images = $form->get('images')->getData();
            foreach($images as $image){
                $folder = 'tricks';
                $fichier = $pictureService->add($image, $folder, 300, 300);

                $img = new Image();
                $img->setName($fichier);
                $img->setUrl($img->getName());

                $entityManager->persist($img);
                $trick->addMedium($img);
            }

            // VIDEOS
            $videos = $form->get('videos')->getData();
            foreach ($videos as $videoUrl) {
                $video = new Video();
                $video->setName(uniqid('video_', true));
                $video->setUrl($videoUrl);

                $entityManager->persist($video);
                $trick->addMedium($video);
            }

            $slug = $slugger->slug($trick->getName());
            $trick->setSlug($slug);
        
            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash('success', 'Trick ajouté avec succès');

            return $this->redirectToRoute('admin_trick_new');
        }

        return $this->render('admin/tricks/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);

    }
}