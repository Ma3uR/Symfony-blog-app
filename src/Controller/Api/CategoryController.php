<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Category;
use App\Service\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/category", name="api_")
 */
class CategoryController extends AbstractApiController {
    /**
     * @Route("/add", name="add_category", methods={"POST"})
     */
    public function addCategory(
        Request $request,
        CategoryService $categoryService
    ): JsonResponse {
        $categoryJson = $request->getContent();
        $category = $categoryService->createFromJson($categoryJson);

        return $this->json($category, 200, []);
    }

    /**
     * @Route("/{id}", name="get_category", methods={"GET"})
     */
    public function getCategory(Category $category): JsonResponse {
        return $this->json($category, 200, []);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"DELETE"})
     */
    public function deleteCategory(EntityManagerInterface $entityManager, Category $category): JsonResponse {
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->json('ok', 200);
    }
}