<?php

namespace App\Controller;

use App\Form\Category\CreateCategoryFormType;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController {
    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, CategoryService $categoryService): Response {
        $form = $this->createForm(CreateCategoryFormType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('category/create.html.twig', [
                'form' => $form->createView()
            ]);
        }

        $data = $form->getData();
        $category = $data['title'];
        $categoryService->createAndPersist($category);
        $this->addFlash('success', 'Category «' . $category . '» created');

        return $this->redirect($this->generateUrl('home'));
    }
}
