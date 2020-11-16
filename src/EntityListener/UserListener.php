<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\PreFlush;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserListener {
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $em;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em) {
        $this->passwordEncoder = $encoder;
        $this->em = $em;
    }

    /** @PreFlush */
    public function preFlush(User $user): void {
        $plainPassword = $user->getPlainPassword();
        if ($plainPassword !== null) {
            $password = $this->passwordEncoder->encodePassword($user, $plainPassword);
            $user->setPassword($password);
        }
    }
}