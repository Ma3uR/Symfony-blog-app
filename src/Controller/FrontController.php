<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController {
    /**
     * @Route("/", name="front")
     */
    public function index(EntityManagerInterface $em): Response {
        $articles = $em->getRepository(Article::class)->getAllArticlesBuilder();

        return $this->render('front/front.html.twig', [
            'page_title' => 'Front page',
            'articles' => $articles
        ]);
    }
}
