<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VideoController extends AbstractController
{
    private SerializerService $serializerService;
    private EntityManagerInterface $entityManager;

    public function __construct(SerializerService $serializerService, EntityManagerInterface $em)
    {
        $this->serializerService = $serializerService;
        $this->entityManager     = $em;
    }

    /**
     * @Route("/create", name="add_video_api")
     */
    public function createApiVideo(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $datas = json_decode($request->getContent(), true);

        if ($datas !== null && $datas !== '') {

            $video = new Video();

            $form = $this->createForm(VideoType::class, $video);

            $form->submit($datas);

            $validate = $validator->validate($video, null, 'newVideo');

            if (count($validate) !== 0) {
                foreach ($validate as $error) {
                    return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                }
            }

            $this->entityManager->persist($video);

            $this->entityManager->flush();

            return new JsonResponse("Your video has been added successfully", Response::HTTP_CREATED);

        } else {
            return new JsonResponse("Something went wrong, please send available datas", Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/getall", name="get_all_video_api")
     */
    public function getAllVideoApi(VideoRepository $videoRepository): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializerService->SimpleSerializer($videoRepository->findAll(),'json'),Response::HTTP_OK);
    }

    /**
     * @Route("/get/{id_item}", name="get_one_video_api")
     */
    public function getOneVideoApi($id_item, VideoRepository $videoRepository): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializerService->SimpleSerializer($videoRepository->findOneBy(['id' => $id_item]),'json'),Response::HTTP_OK);
    }
}
