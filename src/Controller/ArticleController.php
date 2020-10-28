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
 * TODO: where is name ???
 * @Route ("/article")
 */
class ArticleController extends AbstractController {
// TODO: no new line
    /**
     * @Route ("/create", name="create")
     */
    public function create(EntityManagerInterface $em, Request $request, ArticleService $articleService, CategoryService $categoryService): Response {
        // TODO: no new line
        $form = $this->createForm(CreateArticleFormType::class);

        $form->handleRequest($request);
        // TODO: invert logic : if not submitted or not valid render create page
        if ($form->isSubmitted() && $form->isValid()) {
            // TODO: add @var annotation
            $data = $form->getData();
            $category = $categoryService->createAndPersist($data['cat']); // TODO: what is cat? myow
            $articleService->createAndPersist($data['title'], $data['desc'], $category);
            $this->addFlash('success', 'Article: '. $data['title'] .' Created!✅'); 
            return $this->redirect($this->generateUrl('front')); // TODO: new line before return
        }

        return $this->render('article/article.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
