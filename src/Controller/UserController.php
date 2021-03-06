<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ApiToken;
use App\Enum\Flashtypes;
use App\Entity\User;
use App\Form\User\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController {
    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, EntityManagerInterface $em): Response {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('user/registration.html.twig', [
                'form' => $form->createView()
            ]);
        }
        /** @var $user User */
        $user = $form->getData();
        $apiToken = new ApiToken($user);
        $em->persist($apiToken);
        $em->persist($user);
        $em->flush();
        $this->addFlash(Flashtypes::FLASHTYPE, 'User: ' . $user->getUsername() . ' Created!✅');

        return $this->redirect($this->generateUrl('home'));
    }

}
