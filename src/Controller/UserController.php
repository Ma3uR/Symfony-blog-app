<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\User\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController {
    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, UserService $userServicese): Response {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addFlash('notice', 'Invalid form');
            return $this->render('user/registration.html.twig', [
                'form' => $form->createView()
            ]);
        }
        /**
         * @var $data array
         */
        $data = $form->getData();
        $userServicese->createAndPersist($data['user_name'], $data['first_name'], $data['last_name'], $data['password']);
        // TODO: move 'success' to some constant
        // TODO: read about Enum and create enum FlashTypesEnum
        $this->addFlash('success', 'User: ' . $data['user_name'] . ' Created!✅');

        return $this->redirect($this->generateUrl('home'));
    }
}
