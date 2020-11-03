<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ArticleService {
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    public function createAndPersist(Article $article): void {
        // TODO: fix
        $author = $article->getAuthor();
        $title = $article->getTitle();
        $description = $article->getDescription();
        $category = $article->getCategory();
        $article->setAuthor($author)
            ->setTitle($title)
            ->setDescription($description)
            ->setCategory($category);
        $em = $this->em;
        $em->persist($article);
        $em->flush();
    }

    //TODO: persistArticle
}
