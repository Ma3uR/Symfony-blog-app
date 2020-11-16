<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Enum\Flashtypes;
use App\Entity\Article;
use App\Form\Article\CreateArticleFormType;
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
    public function create(Request $request, EntityManagerInterface $em): Response {
        $form = $this->createForm(CreateArticleFormType::class);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('article/create.html.twig', [
                'form' => $form->createView()
            ]);
        }
        /** @var $article Article */
        $article = $form->getData();
        /** @var User $user */
        $user = $this->getUser();
        $article->setAuthor($user);
        $em->persist($article);
        $em->flush();

        $this->addFlash(Flashtypes::FLASHTYPE, 'Article: «' . $article->getTitle() . '» Created!✅');

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route ("/{id}/edit", name="edit")
     */
    public function edit(Article $article): Response {
        $this->denyAccessUnlessGranted('edit', $article);

        return $this->render('article/edit.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route ("/{id}", name="viewSingle")
     */
    public function viewSingle(Article  $article) {
        return $this->render('article/single.html.twig', [
            'article' => $article
        ]);

    }
}
