<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryService {
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator) {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function create($title): Category {
        $category = new Category();
        $category->setTitle($title);

        return $category;
    }

    public function createFromJson($categoryJson) {
        $category = $this->serializer->deserialize($categoryJson, Category::class, 'json');

        $errors = $this->validator->validate($category);
        if (count($errors) > 0) {
            throw new RuntimeException('Category with this title already exist');
        }

        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }
}
