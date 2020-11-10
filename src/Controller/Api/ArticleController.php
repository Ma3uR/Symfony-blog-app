<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Service\ArticleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api", name="api_")
 */
class ArticleController extends AbstractController {

    /**
     * @Route("/articles", name="articles", methods={"GET"})
     */
    public function getArticles(ArticleRepository $articleRepository): JsonResponse {
        $data = $articleRepository->findAll();

        return $this->response($data);
    }

    /**
     * @Route("/article-add", name="add_article", methods={"POST", "GET"})
     */
    public function addArticle(
        Request $request,
        EntityManagerInterface $entityManager,
        ArticleService $articleService,
        ValidatorInterface $validator
    ): JsonResponse {
        $request = $this->transformJsonBody($request);

        if (!$request || !$request->request->get('title') || !$request->request->get('description') || !$request->request->get('category')) {
            throw new \Exception('Missing argument');
        }

        $article = new Article();
        /** @var User $user */
        $user = $this->getUser();
        $article->setAuthor($user);
        $article->setTitle($request->get('title'));
        $article->setDescription($request->get('description'));
        $article->setCategory($request->get('category'));

        $errors = $validator->validate($article);
        if (count($errors) > 0) {
            throw new \RuntimeException('Category with this title already exist');
        }
        $articleService->persistAndFlush($article);

        $data = [
            'status' => 200,
            'success' => "Article added successfully"
        ];

        return $this->response($data);

    }

    /**
     * @Route("/article/{id}", name="get_article", methods={"GET"})
     */
    public function getArticle(ArticleRepository $articleRepository, $id): JsonResponse {
        $article = $articleRepository->find($id);

        if (!$article) {
            $data = [
                'status' => 404,
                'errors' => "Article not found",
            ];

            return $this->response($data, 404);
        }

        return $this->response((array)$article);
    }

    /**
     * @Route("/edit-article/{id}", name="article_edit", methods={"POST"})
     */
    public function editArticle(
        Request $request,
        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
        $id,
        ValidatorInterface $validator
    ): JsonResponse {

        $article = $articleRepository->find($id);

        if (!$article) {
            $data = [
                'status' => 404,
                'errors' => "Article not found",
            ];

            return $this->response($data, 404);
        }

        $request = $this->transformJsonBody($request);

        if (!$request) {
            throw new \Exception();
        }

        $article->setTitle($request->request->get('title'));
        $article->setDescription($request->get('description'));
        $errors = $validator->validate($article);
        if (count($errors) > 0) {
            throw new \RuntimeException('Category with this title already exist');
        }
        $entityManager->flush();

        $data = [
            'status' => 200,
            'errors' => "Article updated successfully",
        ];

        return $this->response($data);

    }

    /**
     * @Route("/article-delete/{id}", name="article_delete", methods={"DELETE"})
     */
    public function deleteArticle(EntityManagerInterface $entityManager, ArticleRepository $articleRepository, $id): JsonResponse {
        $post = $articleRepository->find($id);

        if (!$post) {
            $data = [
                'status' => 404,
                'errors' => "Post not found",
            ];

            return $this->response($data, 404);
        }

        $entityManager->remove($post);
        $entityManager->flush();
        $data = [
            'status' => 200,
            'errors' => "Article deleted successfully",
        ];

        return $this->response($data);
    }

    public function response($data, $status = 200, $headers = []) {
        return new JsonResponse($data, $status, $headers);
    }

    protected function transformJsonBody(Request $request): Request {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
        }

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

}