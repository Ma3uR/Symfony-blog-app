<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * @Route("/user/create", name="user_create")
     * @param UserService $userService
     * @param Request $request
     * @return Response
     */
    public function createAction(UserService $userService, Request $request): Response
    {
        $username = $request->request->get('username');
        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $pass = $request->request->get('pass');

//       if(isset($_POST)){
//           $username = htmlspecialchars($_POST['username']);
//           $firstName = $_POST['firstName'];
//           $lastName = $_POST['lastName'];
//           $pass = $_POST['pass'];
//       }

       $userService->createAndPersist($username,$firstName,$lastName,$pass);

        return $this->render('user/index.html.twig', [
            'title' => 'User created',
            'username' => $username,
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }
}
