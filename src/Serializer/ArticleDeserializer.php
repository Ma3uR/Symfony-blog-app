<?php

namespace App\Serializer;

use App\Entity\User;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

// TODO: it
class ArticleDeserializer extends AbstractController {
    private SerializerInterface $serializer;
    private CategoryRepository $categoryRepository;

    public function __construct(SerializerInterface $serializer, CategoryRepository $categoryRepository) {
        $this->serializer = $serializer;
        $this->categoryRepository = $categoryRepository;
    }

    public function deserialize($articleJson, string $type, string $format, array $context = []) {
        $articleArr = json_decode($articleJson);
        // TODO: add validation
        $categoryId = $articleArr->categoryId;
        $category = $this->categoryRepository->find($categoryId);
        $article = $this->serializer->deserialize($articleJson, $type, $format, $context);
        /** @var $user User */
        // TODO: fetch user from another service :)
        $user = $this->getUser();
        $article->setAuthor($user);
        $article->setCategory($category);

        return $article;
    }
}