<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api", name="api_")
 */
class UserController extends AbstractApiController {
    /**
     * @Route("/users", name="users", methods={"GET"})
     */
    public function getUsers(UserRepository $userRepository): JsonResponse {
        $data = $userRepository->findAll();

        return $this->response($data);
    }

    /**
     * @Route("/user-add", name="add_user", methods={"POST"})
     */
    public function addUser(
        Request $request,
        UserService $userService,
        UserPasswordEncoderInterface $passwordEncoder,
        ValidatorInterface $validator
    ): JsonResponse {
        $request = $this->transformJsonBody($request);
        $user = new User();
        $user->setUsername($request->request->get('username'));
        $user->setFirstName($request->request->get('first-name'));
        $user->setLastName($request->request->get('last-name'));
        $user->setPlainPassword($request->request->get('password'));
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            throw new \RuntimeException('Invalid data, username already exists or password cannot be less than 8 characters');
        }
        $userService->persistAndFlush($user);

        $data = [
            'status' => 200,
            'success' => "User added successfully",
        ];

        return $this->response($data);
    }

    /**
     * @Route("/user/{id}", name="get_user", methods={"GET"})
     */
    public function getOne(User $user): JsonResponse {
        return new JsonResponse($user);
    }

    /**
     * @Route("/account", name="account")
     */
    public function accountApi(): JsonResponse {
        $user = $this->getUser();

        return $this->json($user, 200, [], [
            'groups' => ['main'],
        ]);
    }

    /**
     * @Route("/user-delete/{id}", name="user_delete", methods={"DELETE"})
     */
    public function deleteUser(EntityManagerInterface $entityManager, UserRepository $UserRepository, $id): JsonResponse {
        $user = $UserRepository->find($id);

        if (!$user) {
            $data = [
                'status' => 404,
                'errors' => "User not found",
            ];

            return $this->response($data, 404);
        }

        $entityManager->remove($user);
        $entityManager->flush();
        $data = [
            'status' => 200,
            'errors' => "User deleted successfully",
        ];

        return $this->response($data);
    }

    public function response($data, $status = 200, $headers = []) {
        return new JsonResponse($data, $status, $headers);
    }

    protected function transformJsonBody(Request $request): Request { //todo Replace in service ? (dont repeat your self?)
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
        }

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}