<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {
    private EntityManagerInterface $em;
    private string $appEnv;

    public function __construct(EntityManagerInterface $em, string $appEnv, UserPasswordEncoderInterface $passwordEncoder) {
        $this->em = $em;
        $this->appEnv = $appEnv;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function persistAndFlush(User $user): User {
        $passwordEncoder = $this->passwordEncoder;
        $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $apiToken = new ApiToken($user);
        $apiToken2 = new ApiToken($user);
        $em = $this->em;
        $em->persist($apiToken);
        $em->persist($apiToken2);
        $em->persist($user);
        $em->flush();

        return $user;
    }

    public function getEnvVar(): string {
        return $this->appEnv;
    }
}
