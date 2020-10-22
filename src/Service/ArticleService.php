<?php


namespace App\Service;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class ArticleService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
//        parent::__construct();
    }

    public function createAndFlush($title,$description): void
    {
        $article = new Article();
        $article->setTitle($title)
                ->setDescription($description);
        $em = $this->em;
        $em->persist($article);
        $em->flush();
    }
}