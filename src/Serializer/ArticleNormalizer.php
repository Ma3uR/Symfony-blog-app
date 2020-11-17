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
        /** @var $user User */
        $user = $this->security->getUser();

        $article = new Article($data['title'], $data['description'], $user);

        if (isset($data['category'])) {
            $category = $this->categoryRepository->find($data['category']);
            $article->setCategory($category);
        }

        return $article;
    }
}