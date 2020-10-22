<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * @Route("/user/create")
     * @param UserService $userService
     * @return Response
     */
    public function createAction(UserService $userService): Response
    {
       $userService->createAndFlush('Ivani','Ivan','Ivanov','7896543');

        return $this->render('user/index.html.twig', [
            'title' => 'User created',
        ]);
    }
}
