<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(VideoRepository $videoRepository): Response
    {
        $videos = $videoRepository->findAll();

        return $this->render('home/index.html.twig', [
            'videos' => $videos,
        ]);
    }
}
