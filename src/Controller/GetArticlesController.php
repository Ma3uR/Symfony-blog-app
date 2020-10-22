<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

class GetArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(EntityManagerInterface $em)
    {
        $queryResult = $em->getRepository(Article::class)->getAllArticles();
        $queryResultBuilder = $em->getRepository(Article::class)->getAllArticlesBuilder();
        $queryResultBuilderGroupBy = $em->getRepository(Article::class)->getCountOfArticles();
        $getUserWithMostArticles = $em->getRepository(Article::class)->getUserWithMostArticles();
        dump($getUserWithMostArticles);

        return $this->render('articles/index.html.twig', [
            'title' => 'Articles',
        ]);
    }
}
