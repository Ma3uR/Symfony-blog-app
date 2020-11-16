<?php

namespace App\Serializer;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ArticleNormalizer implements ContextAwareDenormalizerInterface {
    private CategoryRepository $categoryRepository;
    private TokenStorageInterface $user;
    private Security $security;

    public function __construct(
        CategoryRepository $categoryRepository,
        Security $security) {
        $this->categoryRepository = $categoryRepository;
        $this->security = $security;
    }
    public function supportsDenormalization($data, string $type, string $format = null, array $context = []): bool {
        return $type === Article::class;
    }

    public function denormalize($data, string $type, string $format = null, array $context = []): Article {
        if (!isset($data['category'])) {
            $category = null;
        } else {
            $categoryId = $data['category'];
            $category = $this->categoryRepository->find($categoryId);
        }

        $article = new Article();
        /** @var $user User */
        $user = $this->security->getUser();
        $article->setTitle($data['title']);
        $article->setDescription($data['description']);
        $article->setCategory($category);
        $article->setAuthor($user);

        return $article;
    }
}