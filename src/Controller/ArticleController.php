<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\ArticleService;
use App\Service\CategoryService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route ("/created", name="article_create")
     */
    public function createAction(
        ArticleService $articleService,
        UserService $userService,
        CategoryService $categoryService,
        Request $request): Response
    {
        $title = $request->request->get('title');
        $desc = $request->request->get('description');
        $cat = $request->request->get('category');
        $category = $categoryService->createAndPersist($cat);

        $articleService->createAndPersist($title,$desc, $category);


        return $this->render('article/created.html.twig', [
            'page_title' => 'Article created ✅',
            'article_title' => $title,
            'category' => $category->getTitle()
        ]);
    }

    /**
     * @Route ("/create")
     */
    public function create(EntityManagerInterface $em) {

        return $this->render('article/article.html.twig', [
           'page_title'=>'Create article'
        ]);
    }
}
