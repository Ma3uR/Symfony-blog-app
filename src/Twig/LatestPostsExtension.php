<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LatestPostsExtension extends AbstractExtension {
    private ArticleRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $em) {
        $this->repo = $articleRepository;
        $this->em = $em;
    }

    public function getFunctions(): array {
        return [
            new TwigFunction('getLatestPosts', [$this, 'getLatestPost']),
        ];
    }

    public function getLatestPost(): array {
        return $this->em->getRepository(Article::class)->getLatest();
    }
}