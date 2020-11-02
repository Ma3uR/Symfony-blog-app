<?php
declare(strict_types=1);

namespace App\Controller;

use App\Constants;
use App\Entity\Article;
use App\Form\Article\CreateArticleFormType;
use App\Service\ArticleService;
use Doctrine\ORM\EntityManagerInterface;
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
            $this->addFlash('notice', 'Invalid form');

            return $this->render('article/create.html.twig', [
                'form' => $form->createView()
            ]);
        }
        /**
         * @var $data array
         */
        $article = $form->getData();
        $articleService->createAndPersist($article);
        $enum = Constants::get(Constants::FLASHTYPE);
        $this->addFlash($enum->getValue(), 'Article: «' . $article->getTitle() . '» Created!✅');

        return $this->redirect($this->generateUrl('home'));
    }


}
