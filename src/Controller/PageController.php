<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* This controller for all static pages without entities
 */

class PageController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
    public function homeAction(EntityManagerInterface $em): Response {
        $articles = $em->getRepository(Article::class)->getAllArticles();
        $category = $em->getRepository(Category::class)->getAllCategory();

        return $this->render('pages/home.html.twig', [
            'articles' => $articles,
            'category' => $category
        ]);
    }

    public function getLatestPost(EntityManagerInterface $em): Response {
        $articles = $em->getRepository(Article::class)->getLatest();
        return $this->render('base.html.twig', [
            'latest' => $articles
        ]);
    }
}
