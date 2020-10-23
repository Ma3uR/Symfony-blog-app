<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService {
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function createAndPersist($username, $firstName, $lastName, $password): User {
        $user = new User();
        $user->setUsername($username)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPassword($password);
        $em = $this->em;
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
