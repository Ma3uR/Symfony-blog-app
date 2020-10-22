<?php


namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class UserService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
//        parent::__construct();
    }

    public function createAndFlush($username,$firstName,$lastName,$password): void
    {
        $user = new User();
        $user->setUsername($username)
             ->setFirstName($firstName)
             ->setLastName($lastName)
             ->setPassword($password);
        $em = $this->em;
        $em->persist($user);
        $em->flush();
    }
}