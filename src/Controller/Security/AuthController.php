<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthController
 * @package App\Controller
 */
class AuthController extends AbstractController
{

//    Partie website :

    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $lastUsername
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }

// Partie API :

    /**
     * @Route("api/login", name="login_api", methods={"POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return JsonResponse
     */
    public function loginApi(AuthenticationUtils $authenticationUtils): JsonResponse
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return new JsonResponse([$lastUsername, $error]);
    }


    /**
     * @Route("api/login_check", name="api_login_check", methods={"POST"})
     * @return JsonResponse
     */
    public function loginCheck(): JsonResponse
    {
        $user = $this->getUser();

        return new JsonResponse([
            'user' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }
}
