<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService {
    private EntityManagerInterface $em;
    private string $appEnv;

    public function __construct(EntityManagerInterface $em, string $appEnv) {
        $this->em = $em;
        $this->appEnv = $appEnv;
    }

    // TODO: fix logic
    public function createAndPersist(User $user): User {
        $username = $user->getUsername();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $password = $user->getPassword();
        $user->setUsername($username)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPassword($password);
        $em = $this->em;
        $em->persist($user);
        $em->flush();

        return $user;
    }

    public function getEnvVar(): string {
        return $this->appEnv;
    }
}
