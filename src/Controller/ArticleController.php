<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Service\ArticleService;

use App\Service\CategoryService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route ("/article/create", name="article_create")
     * @param ArticleService $articleService
     * @param UserService $userService
     * @param CategoryService $categoryService
     * @param Request $request
     * @return Response
     */
    public function createAction(ArticleService $articleService, UserService $userService, CategoryService $categoryService, Request $request): Response
    {
        $title = $request->request->get('title');
        $desc = $request->request->get('description');
        $cat = $request->request->get('category');
//        $user = $userService->createAndPersist('Jack','Jack','Jones','123321');
        $category = $categoryService->createAndPersist($cat);

        $articleService->createAndPersist($title,$desc, $category);
        return $this->render('article/index.html.twig', [
            'title' => 'Article created',
            'article_title' => $title,
            'category' => $category->getTitle()
        ]);
    }
}
