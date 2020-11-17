<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/user", name="api_")
 */
class UserController extends AbstractApiController {
    /**
     * @Route("/", name="users", methods={"GET"})
     */
    public function getUsers(UserRepository $userRepository): JsonResponse {
        $data = $userRepository->findAll();

        return $this->json($data, 200, [], [
            'groups' => ['main'],
        ]);
    }

    /**
     * @Route("/add", name="add_user", methods={"POST"})
     */
    public function addUser(
        Request $request,
        UserService $userService
    ): JsonResponse {
        $userJson = $request->getContent();
        $user = $userService->createFromJson($userJson);

        return $this->json($user, 200, [], [
           'groups' => ['main']
        ]);
    }

    /**
     * @Route("/{id}", name="get_user", methods={"GET"})
     */
    public function getOne(User $user): JsonResponse {
        return $this->json($user, 200, [], [
            'groups' => ['main']
        ]);
    }

    /**
     * @Route("/account", name="account", methods={"GET"})
     */
    public function accountApi(): JsonResponse {
        $user = $this->getUser();

        return $this->json($user, 200, [], [
            'groups' => ['main'],
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function deleteUser(EntityManagerInterface $entityManager, User $user): JsonResponse {
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json('ok',200);
    }
}