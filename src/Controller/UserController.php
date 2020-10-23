<?php
declare(strict_types=1);

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;


/**
 * @Route("/user", name="user")
 */
class UserController extends AbstractController {
    /**
     * @Route("/create", name="_create")
     */
    public function createAction(UserService $userService, Request $request): Response {
        $username = $request->request->get('username');
        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $pass = $request->request->get('pass');

        $userService->createAndPersist($username, $firstName, $lastName, $pass);

        return $this->render('user/user.html.twig', [
            'title' => 'User created',
            'username' => $username,
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }

    /**
     * @Route("/registration", name="app_registration")
     */
    public function registration(UserService $userService): Response {


        return $this->render('user/registration.html.twig', [
          'env' => $userService->getEnvVar()
        ]);
    }
}
