<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickFormType;
use App\Service\PictureService;
use DateTimeImmutable;
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

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/tricks/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);

    }

    #[Route('/edit/{id}', name:'edit')]
    public function edit(Trick $trick, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, PictureService $pictureService): Response
    {
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
            $trick->setUpdatedAt(new DateTimeImmutable());
        
            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash('success', 'Trick modifié avec succès');

            //return $this->redirectToRoute('home');
        }

        $imageRepository = $entityManager->getRepository(Image::class);
        $images = $imageRepository->findBy(['trick' => $trick]);

        $videoRepository = $entityManager->getRepository(Video::class);
        $videos = $videoRepository->findBy(['trick' => $trick]);

        return $this->render('admin/tricks/edit.html.twig', [
            'trick' => $trick,
            'images' => $images,
            'videos' => $videos,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name:'delete')]
    public function delete(Trick $trick, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $trick->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trick);
            $entityManager->flush();

            $this->addFlash('success', 'Trick supprimé avec succès');
        } else {
            $this->addFlash('danger', 'Token CSRF invalide');
        }

        return $this->redirectToRoute('home');
    }

    #[Route('/delete_image/{id}', name:'delete_image')]
    function delete_image(Image $image, Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        $token = $request->request->get('_token');

    if ($this->isCsrfTokenValid('delete' . $image->getId(), $token)) {

        $name = $image->getName();

        if ($pictureService->delete($name, 'tricks', 300, 300)) {
            $em->remove($image);
            $em->flush();

            $this->addFlash('success', 'Image supprimée avec succès');
        } else {
            $this->addFlash('danger', 'Erreur de suppression');
        }
    } else {
        $this->addFlash('danger', 'Token invalide');
    }

    return $this->redirectToRoute('home');
    }
}