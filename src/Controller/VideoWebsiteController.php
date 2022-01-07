<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Form\RegisterUserType;
use App\Form\VideoWebsiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class VideoWebsiteController extends AbstractController
{
    /**
     * @Route("/video/website", name="video_website")
     * @IsGranted("ROLE_USER")
     */
    public function createVideo(Request $request,UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        $video = new Video();

        $form = $this->createForm(VideoWebsiteType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($video);
            $em->flush();

            $this->addFlash(
                'success',
                "Votre vidéo a bien été ajouté ! Vous pouvez maintenant la retrouver sur la page d'accueil !"
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('video/addVideo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/video/{id}", name="video_one")
     * @IsGranted("ROLE_USER")
     */
    public function oneVideo(Video $video): Response
    {
        return $this->render('video/video.html.twig', [
            'video' => $video,
        ]);
    }
}
