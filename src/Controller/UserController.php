<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * @Route("/user/create", name="user_create")
     * @param UserService $userService
     * @return Response
     */
    public function createAction(UserService $userService): Response
    {
       if(isset($_POST)){
           $username = htmlspecialchars($_POST['username']);
           $firstName = $_POST['firstName'];
           $lastName = $_POST['lastName'];
           $pass = $_POST['pass'];
       }

       $userService->createAndPersist($username,$firstName,$lastName,$pass);

        return $this->render('user/index.html.twig', [
            'title' => 'User created',
            'username' => $username,
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }
}
