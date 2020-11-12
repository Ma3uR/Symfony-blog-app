<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Article;
use App\Entity\Category;
use App\Serializer\ArticleDeserializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArticleService {
    private EntityManagerInterface $em;
    private ValidatorInterface $validator;
    private ArticleDeserializer $articleDeserializer;
    private SerializerInterface $serializer;

    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        ArticleDeserializer $articleDeserializer,
        SerializerInterface $serializer) {
        $this->em = $em;
        $this->validator = $validator;
        $this->articleDeserializer = $articleDeserializer;
        $this->serializer = $serializer;
    }

    public function createAndPersist($author, string $title, string $description, Category $category): void {
        $article = new Article();
        $article->setAuthor($author)
            ->setTitle($title)
            ->setDescription($description)
            ->setCategory($category);
        $em = $this->em;
        $em->persist($article);
        $em->flush();
    }

    public function persistAndFlush(Article $article): Article {
        $em = $this->em;
        $em->persist($article);
        $em->flush();

        return $article;
    }

    public function apiCreate($articleJson): void {
        $article = $this->articleDeserializer->deserialize($articleJson, Article::class, 'json');

        $errors = $this->validator->validate($article);  // todo exception listener,(exceptions returns in JSON)
        if (count($errors) > 0) {
            throw new \RuntimeException('Category with this title already exist');
        }
        /**@var $article Article */
        $this->persistAndFlush($article);
    }

    public function apiEdit($articleJson, $article) {
        $this->serializer->deserialize($articleJson, Article::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $article]);
        if (!$article) {
            $data = [
                'status' => 404,
                'errors' => "Article not found",
            ];

            return new JsonResponse($data);
        }

        $errors = $this->validator->validate($article);
        if (count($errors) > 0) {
            throw new \RuntimeException('Category with this title already exist');
        }
       $this->em->flush();
    }
}
