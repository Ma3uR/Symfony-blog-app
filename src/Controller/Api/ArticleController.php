<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\ArticleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/article", name="api_article_")
 */
class ArticleController extends AbstractController {

    /**
     * @Route("/", name="all", methods={"GET"})
     */
    public function collection(ArticleRepository $articleRepository): JsonResponse {
        $data = $articleRepository->findAll();

        return new JsonResponse($data);
    }

    /**
     * @Route("/add", name="add", methods={"POST"})
     */
    public function add(
        Request $request,
        ArticleService $articleService
    ): JsonResponse {
        $articleJson = $request->getContent();
        $article = $articleService->createFromJson($articleJson);

        return $this->json($article, 200, [], [
            'groups' => ['main']
        ]);
    }

    /**
     * @Route("/{id}", name="get", methods={"GET"})
     */
    public function details(Article $article): JsonResponse {
        return new JsonResponse($article);
    }

    /**
     * @Route("/{id}", name="edit", methods={"PUT"})
     */
    public function edit(
        Request $request,
        Article $article,
        ArticleService $articleService
    ): JsonResponse {
        $articleJson = $request->getContent();
        $articleService->editFromJson($articleJson, $article);

        return new JsonResponse($article);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $entityManager, Article $article): JsonResponse {
        if (!$article) {
            throw new RuntimeException('Article does not exist');
        }
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->json('ok', 200);
    }
}