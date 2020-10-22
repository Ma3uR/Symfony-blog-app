<?php

namespace App\Controller;

use App\Service\ArticleService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route ("/article/create")
     * @param ArticleService $articleService
     * @return Response
     */
    public function createAction(ArticleService $articleService): Response
    {

        $articleService->createAndFlush('Some title','short description');
        return $this->render('article/index.html.twig', [
            'title' => 'Article created',
        ]);
    }
}
