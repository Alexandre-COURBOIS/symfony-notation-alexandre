<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserApiType;
use App\Form\RegisterUserType;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    private SerializerService $serializerService;

    public function __construct(SerializerService $serializerService)
    {
        $this->serializerService = $serializerService;
    }

    /**
     * @Route("/register/api", name="register_api")
     */
    public function registerUserWithApi(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em, Request $request, ValidatorInterface $validator): Response
    {
        $datas = json_decode($request->getContent(), true);

        if ($datas && !empty($datas['email'] && !empty($datas['password']))) {

        $user = new User();

        $form = $this->createForm(RegisterUserApiType::class, $user);

        $form->submit($datas);

            $validate = $validator->validate($user, null, 'Register');

            if (count($validate) !== 0) {
                foreach ($validate as $error) {
                    return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                }
            }

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $user->getPassword()
        );

        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        return new JsonResponse("User created successfully", Response::HTTP_CREATED);

        } else {
            return new JsonResponse("Please verify to send available datas", Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @Route("/register/website", name="register_website")
     */
    public function registerUserWebsite(Request $request,UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('home');
        }

        $user = new User();

        $form = $this->createForm(RegisterUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                "Votre compte à bien été crée ! Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
