<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService {
    private string $appEnv;
    private EntityManagerInterface $em;
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;

    public function __construct(string $appEnv,EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator) {
        $this->appEnv = $appEnv;
        $this->em = $em;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function createUser($username, $firstName, $lastName, $password): User {
        $user = new User();
        $user->setUsername($username);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPlainPassword($password);

        return $user;
    }

    public function createFromJson($userJson): User {
        $user = $this->serializer->deserialize($userJson, User::class, 'json');

        $errors = $this->validator->validate($user);  // todo exception listener,(exceptions returns in JSON)
        if (count($errors) > 0) {
            $message = $errors->get(0);
            throw new \RuntimeException($message->getMessage());
        }
        /** @var $user User */
        $apiToken = new ApiToken($user);
        $this->em->persist($apiToken);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
