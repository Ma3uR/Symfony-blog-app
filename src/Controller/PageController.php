<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
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

        return $this->render('pages/home.html.twig', [
            'articles' => $articles
        ]);
    }
}
