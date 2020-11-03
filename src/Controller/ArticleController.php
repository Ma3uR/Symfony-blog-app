<?php
declare(strict_types=1);

namespace App\Controller;

use App\flashtypes;
use App\Entity\Article;
use App\Form\Article\CreateArticleFormType;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/article", name="article_")
 */
class ArticleController extends AbstractController {
    /**
     * @Route ("/create", name="create")
     */
    public function create(Request $request, ArticleService $articleService): Response {
        $form = $this->createForm(CreateArticleFormType::class);

        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('article/create.html.twig', [
                'form' => $form->createView()
            ]);
        }
        /**
         * @var $article Article
         */
        $article = $form->getData();
        $articleService->persistAndFlush($article);
        $this->addFlash(flashtypes::FLASHTYPE, 'Article: «' . $article->getTitle() . '» Created!✅');

        return $this->redirect($this->generateUrl('home'));
    }

}
