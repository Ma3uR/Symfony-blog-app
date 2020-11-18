<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\User;
use Doctrine\ORM\Mapping\PreFlush;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserListener {
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->passwordEncoder = $encoder;
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