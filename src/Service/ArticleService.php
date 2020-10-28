<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class ArticleService {
    private EntityManagerInterface $em; // todo spaces
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    public function createAndPersist($title, $description, Category $category): void { // todo what types of $title and $description variables?
        $article = new Article();
        $article->setTitle($title)
            ->setDescription($description)
            ->setCategory($category);
        $em = $this->em;
        $em->persist($article);
        $em->flush();
    }
}
