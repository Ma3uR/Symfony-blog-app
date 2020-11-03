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

    public function persistAndFlush(User $user): User {
        $em = $this->em;
        $em->persist($user);
        $em->flush();

        return $user;
    }

    public function getEnvVar(): string {
        return $this->appEnv;
    }
}
