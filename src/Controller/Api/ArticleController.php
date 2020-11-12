<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\ArticleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * TODO: routING fix
 * @Route("/api", name="api_article_")
 */
class ArticleController extends AbstractApiController {

    /**
     * @Route("/articles", name="all", methods={"GET"})
     * TODO: naming fix - collection
     */
    public function getAll(ArticleRepository $articleRepository): JsonResponse {
        $data = $articleRepository->findAll();

        return new JsonResponse($data);
    }

    /**
     * @Route("/article-add", name="add", methods={"POST"})
     */
    public function add(
        Request $request,
        ArticleService $articleService
    ): JsonResponse {
        $articleJson = $request->getContent();
        $articleService->apiCreate($articleJson);

        // TODO: response must contain created entity, not user request
        return new JsonResponse($articleJson);
    }

    /**
     * @Route("/article/{id}", name="get", methods={"GET"})
     * Todo: naming fix - details
     */
    public function getOne(Article $article): JsonResponse {
        return new JsonResponse($article);
    }

    /**
     * TODO: why post?
     * @Route("/edit-article/{id}", name="edit", methods={"POST"})
     */
    public function edit(
        Request $request,
        Article $article,
        ArticleService $articleService
    ): JsonResponse {
        $articleJson = $request->getContent();
        $articleService->apiEdit($articleJson, $article);

        return new JsonResponse($article);
    }

    /**
     * TODO: learn what is requirements
     * @Route("/article-delete/{id}", name="delete", methods={"DELETE"}, requirements={"id":"\d+"})
     */
    public function delete(EntityManagerInterface $entityManager, Article $article): JsonResponse {
        $entityManager->remove($article);
        $entityManager->flush();

        // TODO: return only ok
        $data = [
            'status' => 200,
            'errors' => "Article " . $article->getTitle() . " deleted successfully",
        ];

        return new JsonResponse($data);
    }
}