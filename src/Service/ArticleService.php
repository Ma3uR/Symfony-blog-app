<?php


namespace App\Service;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;


class ArticleService
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createAndPersist(string $title, string $description, User $author, Category $category): void
    {
        $article = new Article();
        $article->setTitle($title)
                ->setAuthor($author)
                ->setDescription($description)
                ->setCategory($category);
        $em = $this->em;
        $em->persist($article);
        $em->flush();
    }
}