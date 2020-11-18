<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArticleService {
    private EntityManagerInterface $em;
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;

    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    // JSON
    public function createFromJson($articleJson): Article {
        /** @var $article Article */
        $article = $this->serializer->deserialize($articleJson, Article::class, 'json');

        $errors = $this->validator->validate($article);  // todo exception listener,(exceptions returns in JSON)

        if (count($errors) > 0) {
            $message = $errors->get(0);
            throw new RuntimeException($message->getMessage());
        }
        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }

    public function editFromJson($articleJson, Article $article): JsonResponse {
        $this->serializer->deserialize($articleJson, Article::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $article
        ]);
        $errors = $this->validator->validate($article);
        if (count($errors) > 0) {
            throw new RuntimeException('Category with this title already exist');
        }
        $this->em->flush();
    }
}
