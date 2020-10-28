<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\Article\CreateArticleFormType;
use App\Service\ArticleService;
use App\Service\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/article")
 */
class ArticleController extends AbstractController {

    /**
     * @Route ("/create", name="create")
     */
    public function create(EntityManagerInterface $em, Request $request, ArticleService $articleService, CategoryService $categoryService): Response {

        $form = $this->createForm(CreateArticleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $category = $categoryService->createAndPersist($data['cat']);
            $articleService->createAndPersist($data['title'], $data['desc'], $category);
            $this->addFlash('success', 'Article: '. $data['title'] .' Created!✅');
            return $this->redirect($this->generateUrl('front'));
        }

        return $this->render('article/article.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
