<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api", name="api_")
 */
class CategoryController {
    /**
     * @Route("/category-add", name="add_category", methods={"POST"})
     */
    public function addCategory(
        Request $request,
        EntityManagerInterface $entityManager,
        CategoryService $categoryService,
        ValidatorInterface $validator
    ): JsonResponse {
        $request = $this->transformJsonBody($request);

        if (!$request || !$request->request->get('title')) {
            throw new \Exception();
        }
        $category = new Category();
        $category->setTitle($request->request->get('title'));

        $errors = $validator->validate($category);
        if (count($errors) > 0) {
            throw new \RuntimeException('Category with this title already exist');
        }
        $categoryService->persistAndFlush($category);

        $data = [
            'status' => 200,
            'success' => "Category added successfully",
        ];

        return $this->response($data);
    }

    /**
     * @Route("/category/{id}", name="get_category", methods={"GET"})
     */
    public function getCategory(CategoryRepository $CategoryRepository, $id): JsonResponse {
        $category = $CategoryRepository->find($id);

        if (!$category) {
            $data = [
                'status' => 404,
                'errors' => "category not found",
            ];

            return $this->response($data, 404);
        }

        return $this->response((array)$category);
    }

    /**
     * @Route("/category-delete/{id}", name="category_delete", methods={"DELETE"})
     */
    public function deleteCategory(EntityManagerInterface $entityManager, CategoryRepository $CategoryRepository, $id): JsonResponse {
        $post = $CategoryRepository->find($id);

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
            'errors' => "Category deleted successfully",
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