<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\Flashtypes;
use App\Entity\User;
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
    public function registration(Request $request, UserService $userService): Response {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('user/registration.html.twig', [
                'form' => $form->createView()
            ]);
        }
        /** @var $user User */
        $user = $form->getData();
        $userService->persistAndFlush($user);
        $this->addFlash(Flashtypes::FLASHTYPE, 'User: ' . $user->getUsername() . ' Created!✅');

        return $this->redirect($this->generateUrl('home'));
    }

}
