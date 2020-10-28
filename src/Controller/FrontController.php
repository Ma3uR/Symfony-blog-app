<?php
declare(strict_types=1); // TODO: new line

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// TODO: describe what is this controller
// TODO: naming fix
class FrontController extends AbstractController {
    /**
     * TODO: naming fix
     * @Route("/", name="front")
     */
    public function index(EntityManagerInterface $em): Response { // TODO: method naming fix
        $articles = $em->getRepository(Article::class)->getAllArticlesBuilder();

        return $this->render('front/front.html.twig', [
            'page_title' => 'Front page', // TODO: remove
            'articles' => $articles
        ]);
    }
}
