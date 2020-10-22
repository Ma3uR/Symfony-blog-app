<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Service\ArticleService;

use App\Service\CategoryService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route ("/article/create")
     * @param ArticleService $articleService
     * @param UserService $userService
     * @param CategoryService $categoryService
     * @return Response
     */
    public function createAction(ArticleService $articleService, UserService $userService, CategoryService $categoryService): Response
    {
        $user = $userService->createAndPersist('Jack','Jack','Jones','123321');
        $category = $categoryService->createAndPersist('For man');

        $articleService->createAndPersist('My title','My short description', $user, $category);
        return $this->render('article/index.html.twig', [
            'title' => 'Article created',
            'user' => $user->getUsername(),
            'category' => $category->getTitle()
        ]);
    }
}
